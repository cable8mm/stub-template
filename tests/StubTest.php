<?php

namespace Cable8mm\StubTemplate\Tests;

use Cable8mm\StubTemplate\Stub;
use PHPUnit\Framework\TestCase;

final class StubTest extends TestCase
{
    public function test_stub_with_dir(): void
    {
        $body = Stub::of('stubs/sample.stub',
            [
                'title' => 'Home Page',
                'colors' => ['red', 'blue', 'green'],
            ],
            __DIR__
        )->render();

        $this->assertStringContainsString('Home Page', $body);
    }

    public function test_stub_without_dir(): void
    {
        $body = Stub::of(__DIR__.'/stubs/sample.stub',
            [
                'title' => 'Home Page',
                'colors' => ['red', 'blue', 'green'],
            ]
        )->render();

        $this->assertStringContainsString('Home Page', $body);
    }

    public function test_expect_exception_without_full_assignments(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Stub::of(__DIR__.'/stubs/sample.stub',
            []
        )->render();
    }
}
