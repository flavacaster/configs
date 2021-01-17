<?php

declare(strict_types=1);

namespace Tests\Unit;

use N7\Configs\AbstractConfig;
use N7\Configs\ConfigInterface;
use PHPUnit\Framework\TestCase;

final class AbstractConfigTest extends TestCase
{
    public function testConfigurationFileValues(): void
    {
        putenv('ENV_INT=10');
        putenv('ENV_BOOL=true');
        putenv('ENV_STR=string');

        $object = $this->getConfigObject();

        $this->assertSame(10, $object->getIntValue());
        $this->assertSame(true, $object->getBoolValue());
        $this->assertSame('string', $object->getStringValue());
    }

    private function getConfigObject(): ConfigInterface
    {
        return new class extends AbstractConfig {
            private ?int $intValue;
            private ?bool $boolValue;
            private ?string $stringValue;

            public function __construct()
            {
                $this->intValue = $this->env()->getInt('ENV_INT');
                $this->boolValue = $this->env()->getBool('ENV_BOOL');
                $this->stringValue = $this->env()->getString('ENV_STR');
            }

            public function getIntValue(): ?int
            {
                return $this->intValue;
            }

            public function getBoolValue(): ?bool
            {
                return $this->boolValue;
            }

            public function getStringValue(): ?string
            {
                return $this->stringValue;
            }
        };
    }
}
