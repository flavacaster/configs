<?php

declare(strict_types=1);

namespace Flavacaster\Configs\TypesCasters;

final class ListTypeCaster implements TypeCasterInterface
{
    private const DELIMITER = ',';

    public function cast($value): array
    {
        if ($value === '') {
            return [];
        }

        return explode(self::DELIMITER, (string) $value);
    }
}
