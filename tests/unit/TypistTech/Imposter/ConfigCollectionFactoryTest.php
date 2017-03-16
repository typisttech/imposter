<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigCollectionFactory
 */
class ConfigCollectionFactoryTest extends \Codeception\Test\Unit
{
    public function testForRootConfig()
    {
        $filesystem = new Filesystem;
        $rootConfig = ConfigFactory::read(
            codecept_data_dir('composer.json'),
            $filesystem
        );

        $actual = ConfigCollectionFactory::forProject(
            $rootConfig,
            codecept_data_dir('tmp-vendor/'),
            $filesystem
        );

        $expected = new ConfigCollection;
        $expected->add($rootConfig);
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-psr4/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-common/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json'),
                $filesystem
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
