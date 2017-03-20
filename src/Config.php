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

class Config implements ConfigInterface
{
    /**
     * @var string
     */
    protected $packageDir;

    /**
     * @var array
     */
    private $config;

    public function __construct(string $packageDir, array $config)
    {
        $this->packageDir = StringUtil::addTrailingSlash($packageDir);
        $this->config     = $config;
    }

    /**
     * @return string[]
     */
    public function getAutoloads(): array
    {
        return array_map(function (string $autoload) {
            return $this->packageDir . $autoload;
        }, array_unique($this->getAutoloadPaths()));
    }

    /**
     * @return string[]
     */
    private function getAutoloadPaths(): array
    {
        $autoload = $this->get('autoload');

        return ArrayUtil::flattenMap(function ($autoloadConfig) {
            return $this->normalizeAutoload($autoloadConfig);
        }, $autoload);
    }

    protected function get(string $key): array
    {
        return $this->config[$key] ?? [];
    }

    /**
     * @param $autoloadConfigs
     *
     * @return string[]
     */
    private function normalizeAutoload($autoloadConfigs): array
    {
        if (!is_array($autoloadConfigs)) {
            return [$autoloadConfigs];
        }

        return ArrayUtil::flattenMap(function ($autoloadConfig) {
            return $this->normalizeAutoload($autoloadConfig);
        }, $autoloadConfigs);
    }

    public function getPackageDir(): string
    {
        return $this->packageDir;
    }

    /**
     * @return string[]
     */
    public function getRequires(): array
    {
        return array_keys($this->get('require'));
    }
}
