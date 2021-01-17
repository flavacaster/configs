<?php

declare(strict_types=1);

namespace N7\Configs\Exceptions;

final class UndefinedPropertyException extends \RuntimeException
{
    public function __construct(string $class, string $property)
    {
        parent::__construct('Undefined property: ' . $class . '::' . $property);
    }
}
