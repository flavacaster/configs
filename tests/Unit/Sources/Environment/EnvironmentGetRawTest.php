<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

final class EnvironmentGetRawTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider rawValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertSame($value, $this->environment->getRaw('ENV_KEY'));
    }

    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined(): void
    {
        putenv('ENV_KEY');

        $this->assertFalse($this->environment->getRaw('ENV_KEY'));
    }

    public function rawValuesProvider(): array
    {
        return [
            [''],
            ['10'],
            ['null'],
            ['string'],
        ];
    }
}
