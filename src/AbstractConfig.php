<?php

declare(strict_types=1);

namespace Flavacaster\Configs;

use Flavacaster\Configs\Sources\EnvironmentSource;

abstract class AbstractConfig implements ConfigInterface
{
    private EnvironmentSource $env;

    protected function env(): EnvironmentSource
    {
        return $this->env = ($this->env ?? new EnvironmentSource());
    }
}
