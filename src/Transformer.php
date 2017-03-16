<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

final class Transformer
{
    /**
     * @var string
     */
    private $vendorPrefix;

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
     * @param string     $vendorPrefix
     * @param string     $target
     * @param Filesystem $filesystem
     */
    public function __construct(string $target, string $vendorPrefix, Filesystem $filesystem)
    {
        $this->vendorPrefix = $vendorPrefix;
        $this->target       = $target;
        $this->filesystem   = $filesystem;
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
        $pattern     = "/$keyword\\s+(?!$this->vendorPrefix)/";
        $replacement = "$keyword $this->vendorPrefix\\";
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
