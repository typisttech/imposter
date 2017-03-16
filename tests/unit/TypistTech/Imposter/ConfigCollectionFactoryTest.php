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
        $actual = ConfigCollectionFactory::forRootConfig(
            codecept_data_dir('composer.json'),
            codecept_data_dir('tmp-vendor/'),
            new Filesystem
        );

        $expected = new ConfigCollection;
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('composer.json'),
                new Filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy/composer.json'),
                new Filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-psr4/composer.json'),
                new Filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-common/composer.json'),
                new Filesystem
            )
        );
        $expected->add(
            ConfigFactory::read(
                codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json'),
                new Filesystem
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
