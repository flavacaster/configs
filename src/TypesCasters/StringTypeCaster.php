<?php

declare(strict_types=1);

namespace N7\Configs\TypesCasters;

final class StringTypeCaster implements TypeCasterInterface
{
    /**
     * @param mixed $value
     * @return string
     */
    public function cast($value): string
    {
        return (string) $value;
    }
}
