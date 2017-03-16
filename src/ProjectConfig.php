<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

final class ProjectConfig extends Config
{
    public function getVendorDir(): string
    {
        $config    = $this->get('config');
        $vendorDir = $config['vendor-dir'] ?? 'vendor';

        return StringUtil::addTrailingSlash($this->packageDir . $vendorDir);
    }
}
