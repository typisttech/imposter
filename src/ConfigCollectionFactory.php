<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

class ConfigCollectionFactory
{
    public static function forProject(
        ProjectConfigInterface $projectConfig,
        Filesystem $filesystem
    ): ConfigCollectionInterface {
        return static::addRequiredPackageConfigsRecursively(
            new ConfigCollection(),
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
        $filteredRequires = static::getFilteredPackages($projectConfig, $config);

        foreach ($filteredRequires as $package) {
            $packageConfig = ConfigFactory::build(
                $projectConfig->getVendorDir() . $package . '/composer.json',
                $filesystem
            );

            $configCollection->add($packageConfig);

            static::addRequiredPackageConfigsRecursively(
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
            return ! in_array($package, $projectConfig->getExcludes(), true);
        });
    }
}
