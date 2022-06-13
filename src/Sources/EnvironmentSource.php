<?php

declare(strict_types=1);

namespace Flavacaster\Configs\Sources;

use Flavacaster\Configs\Exceptions\InvalidParameterValueException;
use Flavacaster\Configs\Exceptions\InvalidValueException;
use Flavacaster\Configs\TypesCasters;
use Closure;

final class EnvironmentSource
{
    private const NULL_VALUES = ['null', '(null)'];

    /**
     * @var TypesCasters\TypeCasterInterface[]
     */
    private array $casters = [];

    public function getBool(string $key, $default = null): bool
    {
        return $this->getEnvironmentValue(TypesCasters\BooleanTypeCaster::class, $key, $default, false);
    }

    public function getNullableBool(string $key, $default = null): ?bool
    {
        return $this->getEnvironmentValue(TypesCasters\BooleanTypeCaster::class, $key, $default, true);
    }

    public function getFloat(string $key, $default = null): float
    {
        return $this->getEnvironmentValue(TypesCasters\FloatTypeCaster::class, $key, $default, false);
    }

    public function getNullableFloat(string $key, $default = null): ?float
    {
        return $this->getEnvironmentValue(TypesCasters\FloatTypeCaster::class, $key, $default, true);
    }

    public function getInt(string $key, $default = null): int
    {
        return $this->getEnvironmentValue(TypesCasters\IntegerTypeCaster::class, $key, $default, false);
    }

    public function getNullableInt(string $key, $default = null): ?int
    {
        return $this->getEnvironmentValue(TypesCasters\IntegerTypeCaster::class, $key, $default, true);
    }

    public function getList(string $key, $default = []): array
    {
        return $this->getEnvironmentValue(TypesCasters\ListTypeCaster::class, $key, $default, false);
    }

    public function getNullableList(string $key, $default = []): ?array
    {
        return $this->getEnvironmentValue(TypesCasters\ListTypeCaster::class, $key, $default, true);
    }

    public function getString(string $key, $default = null): string
    {
        return $this->getEnvironmentValue(TypesCasters\StringTypeCaster::class, $key, $default, false);
    }

    public function getNullableString(string $key, $default = null): ?string
    {
        return $this->getEnvironmentValue(TypesCasters\StringTypeCaster::class, $key, $default, true);
    }

    public function getRaw(string $key)
    {
        return getenv($key);
    }

    private function getEnvironmentValue(string $caster, string $key, $default, bool $nullable)
    {
        $value = getenv($key);

        if ($value === false) {
            $value = array_key_exists($key, $_ENV) ? $_ENV[$key] : false;
        }

        if ($value === false) {
            $preparedDefaultValue = $this->prepareDefaultValue($default);

            if ($preparedDefaultValue === null && !$nullable) {
                throw new \RuntimeException(
                    sprintf('ENV key "%s" is required and cannot be null', $key),
                );
            }
        }

        if ($nullable && $this->isNull($value)) {
            return null;
        }

        try {
            $result = $this->getCaster($caster)->cast($value);
        } catch (InvalidValueException $exception) {
            throw new InvalidParameterValueException($key, $exception);
        }

        return $result;
    }

    private function getCaster(string $caster): TypesCasters\TypeCasterInterface
    {
        return $this->casters[$caster] = ($this->casters[$caster] ?? new $caster());
    }

    private function isNull($value): bool
    {
        if ($value === '') {
            return true;
        }

        if (in_array($value, self::NULL_VALUES, true)) {
            return true;
        }

        return false;
    }

    private function prepareDefaultValue($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
