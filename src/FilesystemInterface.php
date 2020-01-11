<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

interface FilesystemInterface
{
    /**
     * @param string $path
     *
     * @return \SplFileInfo[]
     */
    public function allFiles(string $path): array;

    /**
     * Extract the parent directory from a file path.
     *
     * @param  string $path
     *
     * @return string
     */
    public function dirname(string $path): string;

    /**
     * Get the contents of a file.
     *
     * @param  string $path
     *
     * @return string
     */
    public function get(string $path): string;

    /**
     * Determine if the given path is a file.
     *
     * @param  string $file
     *
     * @return bool
     */
    public function isFile(string $file): bool;

    /**
     * Write the contents of a file.
     *
     * @param  string $path
     * @param  string $contents
     *
     * @return mixed
     */
    public function put(string $path, string $contents);
}
