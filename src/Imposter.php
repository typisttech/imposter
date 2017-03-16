<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

final class Imposter
{
    /**
     * @var ConfigCollection
     */
    private $configCollection;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * Imposter constructor.
     *
     * @param ConfigCollection $configCollection
     * @param Transformer      $transformer
     */
    public function __construct(ConfigCollection $configCollection, Transformer $transformer)
    {
        $this->configCollection = $configCollection;
        $this->transformer      = $transformer;
    }

    /**
     * @return void
     */
    public function run()
    {
        $autoloads = $this->configCollection->getAutoloads();
        array_walk($autoloads, function ($autoload) {
            $this->transformer->transform($autoload);
        });
    }
}
