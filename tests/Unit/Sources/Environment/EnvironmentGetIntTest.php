<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

use N7\Configs\Exceptions\InvalidValueException;

final class EnvironmentGetIntTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider integerValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $actual, int $expected): void
    {
        putenv('ENV_KEY=' . $actual);

        $this->assertSame($expected, $this->environment->getInt('ENV_KEY'));
    }

    /**
     * @dataProvider defaultValuesProvider
     */
    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined($default, int $expect): void
    {
        putenv('ENV_KEY');

        $this->assertSame($expect, $this->environment->getInt('ENV_KEY', $default));
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testItReturnsNullInsteadOfDefaultValueInCaseValueDefinedAsNull(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertNull($this->environment->getInt('ENV_KEY', 10, true));
    }

    public function testItWillThrowExceptionInCaseIfInvalidValueDefined(): void
    {
        putenv('ENV_KEY=asd');

        $this->expectException(InvalidValueException::class);

        $this->environment->getInt('ENV_KEY');
    }

    public function integerValuesProvider(): array
    {
        return [
            ['1234', 1234],
            ['0', 0],
            ['-100', -100],
        ];
    }

    public function defaultValuesProvider(): array
    {
        return [
            [10, 10],
            [0, 0],
            [-10, -10],
            [fn (): int => 10, 10],
        ];
    }
}
