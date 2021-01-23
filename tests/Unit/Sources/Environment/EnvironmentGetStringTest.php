<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

final class EnvironmentGetStringTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider stringValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertSame($value, $this->environment->getString('ENV_KEY', null));
    }

    /**
     * @dataProvider defaultValuesProvider
     */
    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined($default, ?string $expect = null): void
    {
        putenv('ENV_KEY');

        $this->assertSame($expect ?? $default, $this->environment->getString('ENV_KEY', $default));
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testItReturnsNullInsteadOfDefaultValueInCaseValueDefinedAsNull(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertNull($this->environment->getNullableString('ENV_KEY', true));
    }

    public function stringValuesProvider(): array
    {
        return [
            ['adf'],
            ['10'],
            ['null'],
            ['(null)'],
            ['', ''],
        ];
    }

    public function defaultValuesProvider(): array
    {
        return [
            ['adf'],
            [''],
            ['null'],
            [fn (): string => 'asd', 'asd'],
        ];
    }
}
