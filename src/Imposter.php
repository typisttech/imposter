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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        $autoloads = $this->configCollection->getAutoloads();
        array_walk($autoloads, function ($autoload) {
            $this->transformer->transform($autoload);
        });
    }
}
