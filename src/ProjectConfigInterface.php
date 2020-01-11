<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

interface ProjectConfigInterface extends ConfigInterface
{
    /**
     * @return string[]
     */
    public function getExcludes(): array;

    public function getImposterNamespace(): string;

    public function getVendorDir(): string;

    /**
     * @param string[] $extraExcludes
     *
     * @return void
     */
    public function setExtraExcludes(array $extraExcludes);
}
