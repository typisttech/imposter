<?php

declare(strict_types = 1);

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

final class ConfigCollectionFactory
{
    private function __construct()
    {
    }

    public static function forRootConfig(
        string $rootConfigPath,
        string $vendorDir,
        Filesystem $filesystem
    ): ConfigCollection {
        $configCollection = new ConfigCollection;

        $rootConfig = ConfigFactory::read($rootConfigPath, $filesystem);
        self::addConfig($configCollection, $rootConfig, $vendorDir, $filesystem);

        return $configCollection;
    }

    /**
     * @param ConfigCollection $configCollection
     * @param Config           $config
     * @param string           $vendorDir
     * @param Filesystem       $filesystem
     *
     * @return void
     */
    private static function addConfig(
        ConfigCollection $configCollection,
        Config $config,
        string $vendorDir,
        Filesystem $filesystem
    ) {
        $configCollection->add($config);

        $requires = $config->getRequires();
        foreach ($requires as $package) {
            $packageConfig = ConfigFactory::read($vendorDir . $package . '/composer.json', $filesystem);
            self::addConfig($configCollection, $packageConfig, $vendorDir, $filesystem);
        }
    }
}
