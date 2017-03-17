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

final class ConfigCollectionFactory
{
    private function __construct()
    {
    }

    public static function forProject(
        ProjectConfigInterface $projectConfig,
        string $vendorDir,
        Filesystem $filesystem
    ): ConfigCollectionInterface {
        return self::addRequiredPackageConfigsRecursively(
            new ConfigCollection,
            $projectConfig,
            StringUtil::addTrailingSlash($vendorDir),
            $filesystem
        );
    }

    private static function addRequiredPackageConfigsRecursively(
        ConfigCollectionInterface $configCollection,
        ConfigInterface $config,
        string $vendorDir,
        Filesystem $filesystem
    ): ConfigCollectionInterface {
        $configCollection->add($config);

        $requires = $config->getRequires();
        foreach ($requires as $package) {
            $packageConfig = ConfigFactory::build($vendorDir . $package . '/composer.json', $filesystem);
            self::addRequiredPackageConfigsRecursively($configCollection, $packageConfig, $vendorDir, $filesystem);
        }

        return $configCollection;
    }
}
