<?php

declare(strict_types=1);

namespace N7\Configs;

use N7\Configs\Sources\Environment;

abstract class AbstractConfig implements ConfigInterface
{
    private Environment $env;

    protected function env(): Environment
    {
        return $this->env = ($this->env ?? new Environment());
    }
}
