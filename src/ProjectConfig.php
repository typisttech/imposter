<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

use UnexpectedValueException;

class ProjectConfig extends Config implements ProjectConfigInterface
{
    /**
     * @var string[]
     */
    protected const DEFAULT_EXCLUDES = ['typisttech/imposter'];

    /**
     * @var string[]
     */
    private $extraExcludes = [];

    /**
     * @return string[]
     */
    public function getExcludes(): array
    {
        $extra = $this->get('extra');
        $excludes = $extra['imposter']['excludes'] ?? [];

        return array_merge(static::DEFAULT_EXCLUDES, $excludes, $this->extraExcludes);
    }

    public function getImposterNamespace(): string
    {
        $extra = $this->get('extra');

        if (empty($extra['imposter']['namespace'])) {
            throw new UnexpectedValueException('Imposter namespace is empty');
        }

        return $extra['imposter']['namespace'];
    }

    public function getVendorDir(): string
    {
        $config = $this->get('config');
        $vendorDir = $config['vendor-dir'] ?? 'vendor';

        return StringUtil::addTrailingSlash($this->packageDir . $vendorDir);
    }

    /**
     * @param string[] $extraExcludes
     *
     * @return void
     */

    public function setExtraExcludes(array $extraExcludes)
    {
        $this->extraExcludes = $extraExcludes;
    }
}
