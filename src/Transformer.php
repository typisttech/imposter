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

use SplFileInfo;

final class Transformer implements TransformerInterface
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var string
     */
    private $namespacePrefix;

    /**
     * Transformer constructor.
     *
     * @param string              $namespacePrefix
     * @param FilesystemInterface $filesystem
     */
    public function __construct(string $namespacePrefix, FilesystemInterface $filesystem)
    {
        $this->namespacePrefix = StringUtil::ensureDoubleBackwardSlash($namespacePrefix);
        $this->filesystem      = $filesystem;
    }

    /**
     * Transform a file or directory recursively.
     *
     * @todo Skip non-php files.
     *
     * @param string $target Path to the target file or directory.
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
     * @return void
     */
    private function doTransform(string $targetFile)
    {
        $this->prefixNamespace($targetFile);
        $this->prefixUse($targetFile);
    }

    /**
     * Prefix namespace at the given path.
     *
     * @param string $targetFile
     *
     * @return void
     */
    private function prefixNamespace(string $targetFile)
    {
        $pattern     = sprintf(
            '/%1$s\\s+(?!(%2$s)|(Composer(\\\\|;)))/',
            'namespace',
            $this->namespacePrefix
        );
        $replacement = sprintf('%1$s %2$s', 'namespace', $this->namespacePrefix);

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

    /**
     * Prefix use keywords at the given path.
     *
     * @param string $targetFile
     *
     * @return void
     */
    private function prefixUse(string $targetFile)
    {
        $pattern     = sprintf(
            '/%1$s\\s+(?!(%2$s)|(\\\\(?!.*\\\\.*))|(Composer(\\\\|;)|(?!.*\\\\.*)))/',
            'use',
            $this->namespacePrefix
        );
        $replacement = sprintf('%1$s %2$s', 'use', $this->namespacePrefix);

        $this->replace($pattern, $replacement, $targetFile);
    }
}
