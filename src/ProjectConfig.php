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

declare(strict_types=1);

namespace TypistTech\Imposter;

use UnexpectedValueException;

final class ProjectConfig extends Config implements ProjectConfigInterface
{
    public function getImposterExcludes(): array
    {
        $extra = $this->get('extra');
        $excludes = $extra['imposter']['excludes'] ?? [];

        $default = ['typisttech/imposter'];

        return array_merge($default, $excludes);
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
        $config    = $this->get('config');
        $vendorDir = $config['vendor-dir'] ?? 'vendor';

        return StringUtil::addTrailingSlash($this->packageDir . $vendorDir);
    }
}
