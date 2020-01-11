<?php

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
