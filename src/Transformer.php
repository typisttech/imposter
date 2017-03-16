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
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * Transformer constructor.
     *
     * @param string     $vendorPrefix
     * @param Filesystem $filesystem
     */
    public function __construct(string $vendorPrefix, Filesystem $filesystem)
    {
        $this->vendorPrefix = $vendorPrefix;
        $this->filesystem   = $filesystem;
    }

    /**
     * @param string $target
     *
     * @return void
     */
    public function transform(string $target)
    {
        $this->prefix('namespace', $target);
        $this->prefix('use', $target);
    }

    /**
     * Prefix namespace or use keywords at the given path.
     *
     * @param string $keyword Should be one of {namespace, use}
     * @param string $target
     *
     * @return void
     */
    private function prefix(string $keyword, string $target)
    {
        $pattern     = "/$keyword\\s+(?!$this->vendorPrefix)/";
        $replacement = "$keyword $this->vendorPrefix\\";
        $this->replace($pattern, $replacement, $target);
    }

    /**
     * Replace the given string in the given file.
     *
     * @param string $pattern
     * @param string $replacement
     * @param string $target
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function replace(string $pattern, string $replacement, string $target)
    {
        $this->filesystem->put(
            $target,
            preg_replace(
                $pattern,
                $replacement,
                $this->filesystem->get($target)
            )
        );
    }
}
