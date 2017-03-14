<?php

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

class ConfigReader
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

    /**
     * @todo refactor
     *
     * @param string $key
     *
     * @return array
     */
    public function get(string $key): array
    {
        $config = json_decode($this->filesystem->get($this->path), true);

        return $config[$key] ?? [];
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
        return call_user_func_array('array_merge', $autoloads);
    }

    private function normalizeAutoload($configs): array
    {
        if (is_string($configs)) {
            return [$configs];
        }

        $map = array_map([$this, 'normalizeAutoload'], $configs);
        return call_user_func_array('array_merge', $map);
    }
}
