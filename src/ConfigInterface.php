<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

interface ConfigInterface
{
    /**
     * @return string[]
     */
    public function getAutoloads(): array;

    public function getPackageDir(): string;

    /**
     * @return string[]
     */
    public function getRequires(): array;
}
