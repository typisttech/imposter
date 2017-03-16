<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

class ConfigCollection
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
        $autoloads = array_map(function (Config $config) {
            return $config->getAutoloads();
        }, $this->all());

        $autoloads = $this->flatten($autoloads);

        return array_unique($autoloads);
    }

    /**
     * @return Config[]
     */
    public function all(): array
    {
        return $this->configs;
    }

    private function flatten(array $array): array
    {
        return call_user_func_array('array_merge', $array);
    }
}
