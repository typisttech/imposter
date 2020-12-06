<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

interface ImposterInterface
{
    /**
     * Get all valid (exist) autoload paths.
     *
     * @return string[]
     */
    public function getAutoloads(): array;

    /**
     * Get all invalid (not exist) autoload paths.
     *
     * @return string[]
     */
    public function getInvalidAutoloads(): array;

    /**
     * Transform all autoload files.
     *
     * @return void
     */
    public function run();

    /**
     * Transform a file or directory recursively.
     *
     * @param string $target Path to the target file or directory.
     *
     * @return void
     */
    public function transform(string $target);
}
