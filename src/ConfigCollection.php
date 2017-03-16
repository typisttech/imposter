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

declare(strict_types = 1);

namespace TypistTech\Imposter;

final class ConfigCollection
{
    /**
     * @var Config[]
     */
    private $configs = [];

    /**
     * @param Config $config
     *
     * @return void
     */
    public function add(Config $config)
    {
        $this->configs[$config->getPackageDir()] = $config;
    }

    public function getAutoloads(): array
    {
        $autoloads = ArrayUtil::flattenMap(function (Config $config) {
            return $config->getAutoloads();
        }, $this->all());

        return array_unique($autoloads);
    }

    /**
     * @return Config[]
     */
    public function all(): array
    {
        return $this->configs;
    }
}
