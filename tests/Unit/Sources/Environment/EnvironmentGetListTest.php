<?php

declare(strict_types=1);

namespace Tests\Unit\Sources\Environment;

final class EnvironmentGetListTest extends AbstractEnvironmentTestCase
{
    /**
     * @dataProvider listValuesProvider
     */
    public function testItReturnsValueInRequiredDataType(string $actual, array $expected): void
    {
        putenv('ENV_KEY=' . $actual);

        $this->assertSame($expected, $this->environment->getList('ENV_KEY', []));
    }

    /**
     * @dataProvider defaultValuesProvider
     */
    public function testItReturnsDefaultValueInCaseEnvVariableNotDefined($default, array $expect): void
    {
        putenv('ENV_KEY');

        $this->assertSame($expect, $this->environment->getList('ENV_KEY', $default));
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testItReturnsNullInsteadOfDefaultValueInCaseValueDefinedAsNull(string $value): void
    {
        putenv('ENV_KEY=' . $value);

        $this->assertNull($this->environment->getNullableList('ENV_KEY', []));
    }

    public function listValuesProvider(): array
    {
        return [
            ['', []],
            ['item', ['item']],
            ['one,two', ['one', 'two']],
        ];
    }

    public function defaultValuesProvider(): array
    {
        return [
            [[], []],
            [['item'], ['item']],
            [fn (): array => [], []],
            [fn (): array => ['item'], ['item']],
        ];
    }
}
