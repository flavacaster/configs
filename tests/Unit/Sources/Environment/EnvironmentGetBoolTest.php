<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

use N7\Configs\Exceptions\InvalidValueException;

final class EnvironmentGetBoolTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider booleanValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $actual, bool $expected): void
    {
        putenv('ENV_KEY=' . $actual);

        $this->assertSame($expected, $this->environment->getBool('ENV_KEY'));
    }

    /**
     * @dataProvider defaultValuesProvider
     */
    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined($default, bool $expect): void
    {
        putenv('ENV_KEY');

        $this->assertSame($expect, $this->environment->getBool('ENV_KEY', $default));
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testItReturnsNullInsteadOfDefaultValueInCaseValueDefinedAsNull(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertNull($this->environment->getBool('ENV_KEY', true, true));
    }

    public function testItWillThrowExceptionInCaseIfInvalidValueDefined(): void
    {
        putenv('ENV_KEY=asd');

        $this->expectException(InvalidValueException::class);

        $this->environment->getBool('ENV_KEY');
    }

    public function booleanValuesProvider(): array
    {
        return [
            ['true', true],
            ['(true)', true],
            ['false', false],
            ['(false)', false],
        ];
    }

    public function defaultValuesProvider(): array
    {
        return [
            [true, true],
            [false, false],
            [fn (): bool => true, true],
            [fn (): bool => false, false],
        ];
    }
}
