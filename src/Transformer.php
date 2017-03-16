<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;
use SplFileInfo;

class Transformer
{
    /**
     * @var string
     */
    private $namespacePrefix;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * Transformer constructor.
     *
     * @param string     $namespacePrefix
     * @param Filesystem $filesystem
     */
    public function __construct(string $namespacePrefix, Filesystem $filesystem)
    {
        $this->namespacePrefix = $namespacePrefix;
        $this->filesystem      = $filesystem;
    }

    /**
     * @param string $target
     *
     * @return void
     */
    public function transform(string $target)
    {
        if ($this->filesystem->isFile($target)) {
            $this->doTransform($target);

            return;
        }

        $files = $this->filesystem->allFiles($target);

        array_walk($files, function (SplFileInfo $file) {
            $this->doTransform($file->getRealPath());
        });
    }

    /**
     * @param string $targetFile
     *
     * @void
     */
    private function doTransform(string $targetFile)
    {
        $this->prefix('namespace', $targetFile);
        $this->prefix('use', $targetFile);
    }

    /**
     * Prefix namespace or use keywords at the given path.
     *
     * @param string $keyword Should be one of {namespace, use}
     * @param string $targetFile
     *
     * @return void
     */
    private function prefix(string $keyword, string $targetFile)
    {
        $pattern     = "/$keyword\\s+(?!$this->namespacePrefix)/";
        $replacement = "$keyword $this->namespacePrefix\\";

        $this->replace($pattern, $replacement, $targetFile);
    }

    /**
     * Replace the given string in the given file.
     *
     * @param string $pattern
     * @param string $replacement
     * @param string $targetFile
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function replace(string $pattern, string $replacement, string $targetFile)
    {
        $this->filesystem->put(
            $targetFile,
            preg_replace(
                $pattern,
                $replacement,
                $this->filesystem->get($targetFile)
            )
        );
    }
}
