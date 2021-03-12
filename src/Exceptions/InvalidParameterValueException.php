<?php

declare(strict_types=1);

namespace N7\Configs\Exceptions;

final class InvalidParameterValueException extends \RuntimeException
{
    public function __construct(string $name, InvalidValueException $exception)
    {
        parent::__construct(
            'Invalid env parameter "' . $name . '" value, value: ' . var_export($exception->getValue(), true),
            $exception->getCode(),
            $exception
        );
    }
}
