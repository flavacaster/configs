<?php

declare(strict_types=1);

namespace Flavacaster\Configs\TypesCasters;

use Flavacaster\Configs\Exceptions\InvalidValueException;

final class IntegerTypeCaster implements TypeCasterInterface
{
    public function cast($value): int
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        throw new InvalidValueException(self::class, $value);
    }
}
