<?php

declare(strict_types=1);

namespace Flavacaster\Configs\TypesCasters;

use Flavacaster\Configs\Exceptions\InvalidValueException;

final class BooleanTypeCaster implements TypeCasterInterface
{
    private const TRUE_VALUES = ['true', '(true)', '1', 1];
    private const FALSE_VALUES = ['false', '(false)', '0', 0];

    public function cast($value): bool
    {
        $value = strtolower($value);
        
        if (in_array($value, self::TRUE_VALUES, true)) {
            return true;
        }

        if (in_array($value, self::FALSE_VALUES, true)) {
            return false;
        }

        throw new InvalidValueException(self::class, $value);
    }
}
