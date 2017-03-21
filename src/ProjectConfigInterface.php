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

interface ProjectConfigInterface extends ConfigInterface
{
    /**
     * @return string[]
     */
    public function getExcludes(): array;

    public function getImposterNamespace(): string;

    public function getVendorDir(): string;

    /**
     * @param string[] $extraExcludes
     *
     * @return void
     */
    public function setExtraExcludes(array $extraExcludes);
}
