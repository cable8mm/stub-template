<?php

namespace Cable8mm\StubTemplate;

use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Stub
{
    /**
     * @var string The template full name with path
     */
    private string $file;

    /**
     * @var array An array of variables
     */
    private array $args;

    /**
     * Constructor
     *
     * @param  string  $file  file name with full path
     * @param  array  $args  arguments
     */
    private function __construct(string $file, array $args)
    {
        $this->file = $file;

        $this->args = $args;
    }

    /**
     * Render a stub template
     *
     * @return string The method returns a string representation of the template
     *
     * @throws \InvalidArgumentException
     */
    public function render(): string
    {
        $loader = new FilesystemLoader(dirname($this->file));

        $twig = new Environment($loader, ['strict_variables' => true]);

        try {
            $render = $twig->render(basename($this->file), $this->args);
        } catch (Throwable $e) {
            throw new \InvalidArgumentException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $render;
    }

    /**
     * Factory method to create a new instance
     *
     * @param  string  $file  The template filename
     * @param  array  $args  An array of arguments
     * @param  string  $path  The template path
     * @return static The new instance
     *
     * @throws \InvalidArgumentException
     *
     * @example Stub::of('stubs/sample.stub', [ 'title' => 'Home Page', 'colors' => ['red', 'blue', 'green'], ], __DIR__)
     * @example Stub::of(__DIR__.'/stubs/sample.stub', [ 'title' => 'Home Page', 'colors' => ['red', 'blue', 'green'], ])
     */
    public static function of(string $file, array $args = [], string $path = ''): static
    {
        $templatePath = empty($path) ? $file : $path.DIRECTORY_SEPARATOR.$file;
        $resolvedFile = realpath($templatePath);

        if ($resolvedFile === false) {
            throw new \InvalidArgumentException("Template file not found: {$templatePath}");
        }

        return new self($resolvedFile, $args);
    }
}
