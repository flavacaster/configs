<?php

declare(strict_types=1);

namespace Flavacaster\Configs\TypesCasters;

use Flavacaster\Configs\Exceptions\InvalidValueException;

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
