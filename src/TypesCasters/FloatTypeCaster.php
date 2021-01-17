<?php

declare(strict_types=1);

namespace N7\Configs\TypesCasters;

use N7\Configs\Exceptions\InvalidValueException;

final class FloatTypeCaster implements TypeCasterInterface
{
    public function cast($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        throw new InvalidValueException(self::class, $value);
    }
}
