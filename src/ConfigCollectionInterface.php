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

interface ConfigCollectionInterface
{
    /**
     * @param ConfigInterface $config
     *
     * @return void
     */
    public function add(ConfigInterface $config);

    /**
     * @return ConfigInterface[]
     */
    public function all(): array;

    /**
     * @return string[]
     */
    public function getAutoloads(): array;
}
