<?php

declare(strict_types=1);

namespace Flavacaster\Configs\Exceptions;

final class InvalidValueException extends \RuntimeException
{
    private string $caster;
    private $value;

    public function __construct(string $caster, $value)
    {
        $this->caster = $caster;
        $this->value = $value;

        parent::__construct('Invalid value passed to ' . $caster . ', value: ' . var_export($value, true));
    }

    public function getCaster(): string
    {
        return $this->caster;
    }

    public function getValue()
    {
        return $this->value;
    }
}
