<?php

declare(strict_types=1);

namespace N7\Configs\Exceptions;

final class InvalidValueException extends \RuntimeException
{
    public function __construct(string $caster, $value)
    {
        parent::__construct('Invalid value passed to ' . $caster . ', value: ' . var_export($value, true));
    }
}
