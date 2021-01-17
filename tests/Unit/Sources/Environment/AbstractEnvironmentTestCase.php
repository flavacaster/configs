<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

use N7\Configs\Sources\Environment;
use PHPUnit\Framework\TestCase;

abstract class AbstractEnvironmentTestCase extends TestCase
{
    protected Environment $environment;

    public function setUp(): void
    {
        parent::setUp();

        $this->environment = new Environment();
    }

    public function nullValuesProvider(): array
    {
        return [
            ['null'],
            ['(null)'],
        ];
    }
}
