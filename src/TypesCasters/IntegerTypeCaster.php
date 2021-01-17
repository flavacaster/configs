<?php

declare(strict_types=1);

namespace N7\Configs\TypesCasters;

use N7\Configs\Exceptions\InvalidValueException;

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
