<?php

namespace Cable8mm\StubTemplate;

use Throwable;

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
        $loader = new \Twig\Loader\FilesystemLoader(dirname($this->file));

        $twig = new \Twig\Environment($loader, ['strict_variables' => true]);

        try {
            $render = $twig->render(basename($this->file), $this->args);
        } catch (Throwable $e) {
            throw new \InvalidArgumentException($e->getMessage());
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
     * @example Stub::of('stubs/sample.stub', [ 'title' => 'Home Page', 'colors' => ['red', 'blue', 'green'], ], __DIR__)
     * @example Stub::of(__DIR__.'/stubs/sample.stub', [ 'title' => 'Home Page', 'colors' => ['red', 'blue', 'green'], ])
     */
    public static function of(string $file, array $args = [], string $path = ''): static
    {
        $file = empty($path) ? realpath($file) : realpath($path.DIRECTORY_SEPARATOR.$file);

        return new self($file, $args);
    }
}
