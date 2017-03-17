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

class Imposter implements ImposterInterface
{
    /**
     * @var ConfigCollectionInterface
     */
    protected $configCollection;

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * @return ConfigCollectionInterface
     */
    public function getConfigCollection(): ConfigCollectionInterface
    {
        return $this->configCollection;
    }

    /**
     * @return TransformerInterface
     */
    public function getTransformer(): TransformerInterface
    {
        return $this->transformer;
    }

    /**
     * Imposter constructor.
     *
     * @param ConfigCollectionInterface $configCollection
     * @param TransformerInterface      $transformer
     */
    public function __construct(ConfigCollectionInterface $configCollection, TransformerInterface $transformer)
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
        array_walk($autoloads, [$this, 'transform']);
    }

    public function transform(string $target)
    {
        $this->transformer->transform($target);
    }
}
