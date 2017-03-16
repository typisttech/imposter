<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

class Config
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

    public function getPackageDir(): string
    {
        return $this->packageDir;
    }

    public function getRequires(): array
    {
        $require = $this->get('require');

        return array_filter(array_keys($require), function (string $package) {
            return $package !== 'typisttech/imposter';
        });
    }

    protected function get(string $key): array
    {
        return $this->config[$key] ?? [];
    }

    public function getAutoloads(): array
    {
        return array_map(function (string $autoload) {
            return $this->packageDir . $autoload;
        }, array_unique($this->getAutoloadPaths()));
    }

    private function getAutoloadPaths(): array
    {
        $autoload = $this->get('autoload');

        return ArrayUtil::flattenMap(function ($autoloadConfig) {
            return $this->normalizeAutoload($autoloadConfig);
        }, $autoload);
    }

    private function normalizeAutoload($autoloadConfigs): array
    {
        if (! is_array($autoloadConfigs)) {
            return [$autoloadConfigs];
        }

        return ArrayUtil::flattenMap(function ($autoloadConfig) {
            return $this->normalizeAutoload($autoloadConfig);
        }, $autoloadConfigs);
    }
}
