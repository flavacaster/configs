<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

use N7\Configs\Exceptions\InvalidValueException;

final class EnvironmentGetFloatTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider floatValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $actual, float $expected): void
    {
        putenv('ENV_KEY=' . $actual);

        $this->assertSame($expected, $this->environment->getFloat('ENV_KEY'));
    }

    /**
     * @dataProvider defaultValuesProvider
     */
    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined($default, float $expect): void
    {
        putenv('ENV_KEY');

        $this->assertSame($expect, $this->environment->getFloat('ENV_KEY', $default));
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testItReturnsNullInsteadOfDefaultValueInCaseValueDefinedAsNull(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertNull($this->environment->getNullableFloat('ENV_KEY', 10.0));
    }

    public function testItWillThrowExceptionInCaseIfInvalidValueDefined(): void
    {
        putenv('ENV_KEY=asd');

        $this->expectException(InvalidValueException::class);

        $this->environment->getFloat('ENV_KEY');
    }

    public function floatValuesProvider(): array
    {
        return [
            ['100.22', 100.22],
            ['100', 100.0],
            ['0', 0.0],
            ['-10', -10.0],
            ['-10.02', -10.02],
        ];
    }

    public function defaultValuesProvider(): array
    {
        return [
            [100.22, 100.22],
            [0, 0.0],
            [fn (): float => 10.11, 10.11],
            [fn (): float => -22.22, -22.22],
        ];
    }
}
