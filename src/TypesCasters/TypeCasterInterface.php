<?php

declare(strict_types=1);

namespace N7\Configs\TypesCasters;

interface TypeCasterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function cast($value);
}
