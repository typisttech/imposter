<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

final class ConfigCollectionFactory
{
    private function __construct()
    {
    }

    public static function forProject(Config $config, string $vendorDir, Filesystem $filesystem): ConfigCollection
    {
        return self::addRequiredPackageConfigsRecursively(new ConfigCollection, $config, $vendorDir, $filesystem);
    }

    private static function addRequiredPackageConfigsRecursively(
        ConfigCollection $configCollection,
        Config $config,
        string $vendorDir,
        Filesystem $filesystem
    ): ConfigCollection {
        $configCollection->add($config);

        $requires = $config->getRequires();
        foreach ($requires as $package) {
            $packageConfig = ConfigFactory::read($vendorDir . $package . '/composer.json', $filesystem);
            self::addRequiredPackageConfigsRecursively($configCollection, $packageConfig, $vendorDir, $filesystem);
        }

        return $configCollection;
    }
}
