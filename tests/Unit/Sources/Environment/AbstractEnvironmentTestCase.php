<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

use N7\Configs\Sources\EnvironmentSource;
use PHPUnit\Framework\TestCase;

abstract class AbstractEnvironmentTestCase extends TestCase
{
    protected EnvironmentSource $environment;

    public function setUp(): void
    {
        parent::setUp();

        $this->environment = new EnvironmentSource();
    }

    public function nullValuesProvider(): array
    {
        return [
            ['null'],
            ['(null)'],
        ];
    }
}
