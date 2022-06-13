<?php

namespace Tests\Unit\Sources\Environment;

final class EnvironmentGetNotNullable extends AbstractEnvironmentTestCase
{
    public function testErrorIsThrownWhenNeeded(): void
    {
        $key = 'ENV_TEST_KEY';

        $this->assertNull($this->environment->getNullableString($key));

        try {
            $this->environment->getString($key);
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('is required and cannot be null', $exception->getMessage());
        }

        putenv($key . '=testValue');

        $this->assertSame('testValue', $this->environment->getString($key));
    }
}
