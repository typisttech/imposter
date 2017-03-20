<?php
/**
 * Imposter
 *
 * Wrapping all composer vendor packages inside your own namespace.
 * Intended for WordPress plugins.
 *
 * @package   TypistTech\Imposter
 * @author    Typist Tech <imposter@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   MIT
 * @see       https://www.typist.tech/projects/imposter
 */

declare(strict_types=1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;
use SplFileInfo;

final class Transformer implements TransformerInterface
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $namespacePrefix;

    /**
     * Transformer constructor.
     *
     * @param string     $namespacePrefix
     * @param Filesystem $filesystem
     */
    public function __construct(string $namespacePrefix, Filesystem $filesystem)
    {
        $this->namespacePrefix = StringUtil::ensureDoubleBackwardSlash($namespacePrefix);
        $this->filesystem      = $filesystem;
    }

    /**
     * Transform a file or directory recursively.
     *
     * @param string $target Path to the target file or directory.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
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
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function prefix(string $keyword, string $targetFile)
    {
        $pattern     = sprintf(
            '/%1$s\\s+(?!(%2$s)|((Composer|TypistTech\\\\Imposter)(\\\\|;)))/',
            $keyword,
            $this->namespacePrefix
        );
        $replacement = sprintf('%1$s %2$s', $keyword, $this->namespacePrefix);

        $this->replace($pattern, $replacement, $targetFile);
    }

    /**
     * Replace string in the given file.
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
