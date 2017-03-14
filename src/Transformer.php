<?php

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

class Transformer
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $target;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * Transformer constructor.
     *
     * @param string     $prefix
     * @param string     $target
     * @param Filesystem $filesystem
     */
    public function __construct(string $target, string $prefix, Filesystem $filesystem)
    {
        $this->prefix     = $prefix;
        $this->target     = $target;
        $this->filesystem = $filesystem;
    }

    public function run()
    {
        $this->prefix('namespace');
        $this->prefix('use');
    }

    /**
     * Prefix namespace or use keywords at the given path.
     *
     * @param string $keyword Should be one of {namespace, use}
     *
     * @return void
     */
    private function prefix(string $keyword)
    {
        $pattern     = "/$keyword\\s+(?!$this->prefix)/";
        $replacement = "$keyword $this->prefix\\";
        $this->replace($pattern, $replacement);
    }

    /**
     * Replace the given string in the given file.
     *
     * @param  string $pattern
     * @param  string $replacement
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function replace(string $pattern, string $replacement)
    {
        $this->filesystem->put(
            $this->target,
            preg_replace(
                $pattern,
                $replacement,
                $this->filesystem->get($this->target)
            )
        );
    }
}
