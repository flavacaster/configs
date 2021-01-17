<?php

declare(strict_types=1);

namespace N7\Configs;

use N7\Configs\Exceptions;
use N7\Configs\Sources\Environment;

/**
 * @property Environment $env
 */
abstract class AbstractConfig implements ConfigInterface
{
    private const ENV_PROPERTY = 'env';

    private Environment $env;

    /**
     * Small hack to avoid creating a constructor.
     *
     * @param string $name
     * @return Environment|mixed
     */
    public function __get(string $name)
    {
        if ($name === self::ENV_PROPERTY) {
            return $this->env = ($this->env ?? new Environment());
        }

        throw new Exceptions\UndefinedPropertyException(static::class, $name);
    }
}
