<?php

declare(strict_types=1);

namespace N7\Configs\Sources;

use N7\Configs\TypesCasters;
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
            return $this->prepareDefaultValue($default);
        }

        if ($nullable && $this->isNull($value)) {
            return null;
        }

        return $this->getCaster($caster)->cast($value);
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
