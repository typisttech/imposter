<?php

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

class Config
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var array
     */
    private $config;

    /**
     * Finder constructor.
     *
     * @param string     $path Path to package composer.json
     * @param Filesystem $filesystem
     */
    public function __construct(string $path, Filesystem $filesystem)
    {
        $this->path       = $path;
        $this->filesystem = $filesystem;
    }

    public function getRequires(): array
    {
        $require = $this->get('require');

        return array_filter(array_keys($require), function ($name) {
            return $name !== 'typisttech/imposter';
        });
    }

    private function get(string $key): array
    {
        if (empty($this->config)) {
            $this->config = json_decode($this->filesystem->get($this->path), true);
        }

        return $this->config[$key] ?? [];
    }

    public function getAutoloads(): array
    {
        $packageDir = $this->filesystem->dirname($this->path);

        return array_map(function ($autoload) use ($packageDir) {
            return "$packageDir/$autoload";
        }, $this->getAutoloadPaths());
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

    private function normalizeAutoload($configs): array
    {
        if (is_string($configs)) {
            return [$configs];
        }

        $map = array_map([$this, 'normalizeAutoload'], $configs);

        return $this->flatten($map);
    }
}
