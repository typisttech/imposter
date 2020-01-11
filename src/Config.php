<?php

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
        $this->config = $config;
    }

    /**
     * @return string[]
     */
    public function getAutoloads(): array
    {
        return array_map(function (string $autoload): string {
            return $this->packageDir . $autoload;
        }, array_unique($this->getAutoloadPaths()));
    }

    /**
     * @return string[]
     */
    private function getAutoloadPaths(): array
    {
        return ArrayUtil::flattenMap(function ($autoloadConfig): array {
            return $this->normalizeAutoload($autoloadConfig);
        }, $this->get('autoload'));
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
        if (! is_array($autoloadConfigs)) {
            return [$autoloadConfigs];
        }

        return ArrayUtil::flattenMap(function ($autoloadConfig): array {
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
