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

final class ConfigCollectionFactory
{
    private function __construct()
    {
    }

    public static function forProject(
        ProjectConfigInterface $projectConfig,
        Filesystem $filesystem
    ): ConfigCollectionInterface {
        return self::addRequiredPackageConfigsRecursively(
            new ConfigCollection,
            $projectConfig,
            $projectConfig,
            $filesystem
        );
    }

    private static function addRequiredPackageConfigsRecursively(
        ConfigCollectionInterface $configCollection,
        ProjectConfigInterface $projectConfig,
        ConfigInterface $config,
        Filesystem $filesystem
    ): ConfigCollectionInterface {
        $filteredRequires = self::getFilteredPackages($projectConfig, $config);

        foreach ($filteredRequires as $package) {
            $packageConfig = ConfigFactory::build(
                $projectConfig->getVendorDir() . $package . '/composer.json',
                $filesystem
            );

            $configCollection->add($packageConfig);

            self::addRequiredPackageConfigsRecursively(
                $configCollection,
                $projectConfig,
                $packageConfig,
                $filesystem
            );
        }

        return $configCollection;
    }

    /**
     * @param ProjectConfigInterface $projectConfig
     * @param ConfigInterface        $config
     *
     * @return string[]
     */
    private static function getFilteredPackages(ProjectConfigInterface $projectConfig, ConfigInterface $config): array
    {
        $requiredPackages = array_filter($config->getRequires(), function (string $package) {
            return (false !== strpos($package, '/'));
        });

        $nonComposerPackages = array_filter($requiredPackages, function (string $package) {
            return (false === strpos($package, 'composer/'));
        });

        return array_filter($nonComposerPackages, function (string $package) use ($projectConfig) {
            return !in_array($package, $projectConfig->getExcludes(), true);
        });
    }
}
