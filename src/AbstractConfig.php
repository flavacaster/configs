<?php

declare(strict_types=1);

namespace N7\Configs;

use N7\Configs\Sources\EnvironmentSource;

abstract class AbstractConfig implements ConfigInterface
{
    private EnvironmentSource $env;

    protected function env(): EnvironmentSource
    {
        return $this->env = ($this->env ?? new EnvironmentSource());
    }
}
