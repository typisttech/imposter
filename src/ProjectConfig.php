<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use UnexpectedValueException;

final class ProjectConfig extends Config
{
    public function getVendorDir(): string
    {
        $config    = $this->get('config');
        $vendorDir = $config['vendor-dir'] ?? 'vendor';

        return StringUtil::addTrailingSlash($this->packageDir . $vendorDir);
    }

    public function getImposterNamespace(): string
    {
        $extra = $this->get('extra');

        if (empty($extra['imposter']['namespace'])) {
            throw new UnexpectedValueException('Imposter namespace is empty');
        }

        return $extra['imposter']['namespace'];
    }
}
