<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

class Imposter implements ImposterInterface
{
    /**
     * @var string[]
     */
    private $autoloads;

    /**
     * @var ConfigCollectionInterface
     */
    private $configCollection;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * Imposter constructor.
     *
     * @param ConfigCollectionInterface $configCollection
     * @param TransformerInterface      $transformer
     */
    public function __construct(ConfigCollectionInterface $configCollection, TransformerInterface $transformer)
    {
        $this->configCollection = $configCollection;
        $this->transformer = $transformer;
    }

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
     * Transform all autoload files.
     *
     * Returns an array of paths that weren't found
     * @return string[]
     */
    public function run()
    {
        $autoloads = $this->getAutoloads();
        array_walk($autoloads, [$this, 'transform']);

        $notfound = [];
        foreach ($autoloads as $autoload) {
            try {
                $this->transform($autoload);
            } catch (PathNotFoundException $exception) {
                $notfound[] = $exception->getPath();
            }
        }

        return $notfound;
    }

    /**
     * Get all autoload paths.
     *
     * @return string[]
     */
    public function getAutoloads(): array
    {
        if (empty($this->autoloads)) {
            $this->autoloads = $this->configCollection->getAutoloads();
        }

        return $this->autoloads;
    }

    /**
     * Transform a file or directory recursively.
     *
     * @param string $target Path to the target file or directory.
     * @throws PathNotFoundException
     * @return void
     */
    public function transform(string $target)
    {
        $this->transformer->transform($target);
    }
}
