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

interface ImposterInterface
{
    /**
     * Get all autoload paths.
     *
     * @return string[]
     */
    public function getAutoloads(): array;

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
