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
     * @var string[]
     */
    private $invalidAutoloads;

    /**
     * @var ConfigCollectionInterface
     */
    private $configCollection;

    /**
     * @var TransformerInterface
     */
    private $transformer;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Imposter constructor.
     *
     * @param ConfigCollectionInterface $configCollection
     * @param TransformerInterface      $transformer
     * @param FilesystemInterface       $filesystem
     */
    public function __construct(
        ConfigCollectionInterface $configCollection,
        TransformerInterface $transformer,
        FilesystemInterface $filesystem
    ) {
        $this->configCollection = $configCollection;
        $this->transformer = $transformer;
        $this->filesystem = $filesystem;
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
     * @return void
     */
    public function run()
    {
        $autoloads = $this->getAutoloads();
        array_walk($autoloads, [$this, 'transform']);
    }

    /**
     * Get all valid (exist) autoload paths.
     *
     * @return string[]
     */
    public function getAutoloads(): array
    {
        if ($this->autoloads === null) {
            $this->setAutoloads();
        }

        return $this->autoloads;
    }

    /**
     * Get all autoload paths which defined in composer.json but not exist.
     *
     * @return string[]
     */
    public function getInvalidAutoloads(): array
    {
        if ($this->invalidAutoloads === null) {
            $this->setAutoloads();
        }

        return $this->invalidAutoloads;
    }

    protected function setAutoloads(): void
    {
        $this->autoloads = [];
        $this->invalidAutoloads = [];

        $autoloads = $this->configCollection->getAutoloads();

        foreach ($autoloads as $autoload) {
            $isValid = $this->filesystem->isFile($autoload) || $this->filesystem->isDir($autoload);

            if ($isValid) {
                $this->autoloads[] = $autoload;
            } else {
                $this->invalidAutoloads[] = $autoload;
            }
        }
    }

    /**
     * Transform a file or directory recursively.
     *
     * @param string $target Path to the target file or directory.
     *
     * @return void
     */
    public function transform(string $target)
    {
        $this->transformer->transform($target);
    }
}
