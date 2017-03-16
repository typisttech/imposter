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

use Illuminate\Filesystem\Filesystem;

final class ImposterFactory
{
    private function __construct()
    {
    }

    public static function forProject(string $projectPath): Imposter
    {
        $filesystem    = new Filesystem;
        $projectConfig = ConfigFactory::buildProjectConfig($projectPath . '/composer.json', $filesystem);

        $transformer      = new Transformer($projectConfig->getImposterNamespace(), $filesystem);
        $configCollection = ConfigCollectionFactory::forProject(
            $projectConfig,
            $projectConfig->getVendorDir(),
            $filesystem
        );

        return new Imposter($configCollection, $transformer);
    }
}
