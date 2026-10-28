<?php

namespace Cable8mm\StubTemplate\Tests;

use Cable8mm\StubTemplate\Stub;
use PHPUnit\Framework\TestCase;
use Twig\Error\RuntimeError;

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

    public function test_php_code_is_not_executed(): void
    {
        $body = Stub::of('stubs/sample.stub',
            [
                'title' => 'Home Page',
                'colors' => ['red', 'blue', 'green'],
            ],
            __DIR__
        )->render();

        // PHP 코드가 실행되지 않고 그대로 출력되는지 확인
        $this->assertStringContainsString('<?php echo date', $body);
        $this->assertStringContainsString("'Y-m-d'", $body);

        // 실제 날짜가 출력되지 않는지 확인 (PHP 코드가 실행되지 않음)
        $this->assertStringNotContainsString('2024', $body);
        $this->assertStringNotContainsString('2025', $body);
    }

    public function test_full_render_result(): void
    {
        $body = Stub::of('stubs/sample.stub',
            [
                'title' => 'Home Page',
                'colors' => ['red', 'blue', 'green'],
            ],
            __DIR__
        )->render();

        $expected = <<<'TWIG'
Home Page - <?php echo date('Y-m-d') ?>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
    <li>red</li>
    <li>blue</li>
    <li>green</li>
</ul>

TWIG;

        $this->assertSame($expected, $body);
    }

    public function test_twig_loop_works_correctly(): void
    {
        $body = Stub::of('stubs/sample.stub',
            [
                'title' => 'Test',
                'colors' => ['red'],
            ],
            __DIR__
        )->render();

        $this->assertStringContainsString('<li>red</li>', $body);
        $this->assertStringNotContainsString('<li>blue</li>', $body);
    }

    public function test_expect_exception_with_non_existent_file(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Template file not found: '.__DIR__.'/non_existent.stub');

        Stub::of('non_existent.stub',
            [
                'title' => 'Test',
            ],
            __DIR__
        )->render();
    }

    public function test_render_exception_preserves_original_exception(): void
    {
        $template = tempnam(sys_get_temp_dir(), 'stub-template-');
        file_put_contents($template, '{{ missing.value }}');

        try {
            Stub::of($template)->render();
            $this->fail('Expected rendering to throw an InvalidArgumentException.');
        } catch (\InvalidArgumentException $exception) {
            $this->assertInstanceOf(RuntimeError::class, $exception->getPrevious());
        } finally {
            unlink($template);
        }
    }
}
