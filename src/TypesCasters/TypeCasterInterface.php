<?php

declare(strict_types=1);

namespace Flavacaster\Configs\TypesCasters;

interface TypeCasterInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function cast($value);
}
