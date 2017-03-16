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

        return array_filter(array_keys($require), function ($name) {
            return $name !== 'typisttech/imposter';
        });
    }

    protected function get(string $key): array
    {
        return $this->config[$key] ?? [];
    }

    public function getAutoloads(): array
    {
        return array_map(function ($autoload) {
            return $this->packageDir . $autoload;
        }, array_unique($this->getAutoloadPaths()));
    }

    private function getAutoloadPaths(): array
    {
        $autoload = $this->get('autoload');

        $autoloads = array_map([$this, 'normalizeAutoload'], $autoload);

        return $this->flatten($autoloads);
    }

    private function flatten(array $array): array
    {
        return call_user_func_array('array_merge', $array);
    }

    private function normalizeAutoload($autoloadConfigs): array
    {
        if (! is_array($autoloadConfigs)) {
            return [$autoloadConfigs];
        }

        $autoloadPaths = array_map([$this, 'normalizeAutoload'], $autoloadConfigs);

        return $this->flatten($autoloadPaths);
    }
}
