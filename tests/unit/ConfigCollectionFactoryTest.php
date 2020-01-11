<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigCollectionFactory
 */
class ConfigCollectionFactoryTest extends Unit
{
    /**
     * @covers \TypistTech\Imposter\ConfigCollectionFactory
     */
    public function testForProject()
    {
        $filesystem = new Filesystem();
        $projectConfig = ConfigFactory::buildProjectConfig(
            codecept_data_dir('composer.json'),
            $filesystem
        );

        $actual = ConfigCollectionFactory::forProject(
            $projectConfig,
            $filesystem
        );

        $expected = new ConfigCollection();
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-psr4/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-common/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-no-autoload/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json'),
                $filesystem
            )
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigCollectionFactory
     */
    public function testForProjectExcludes()
    {
        $filesystem = new Filesystem();
        $projectConfig = ConfigFactory::buildProjectConfig(
            codecept_data_dir('excludes.json'),
            $filesystem
        );

        $actual = ConfigCollectionFactory::forProject(
            $projectConfig,
            $filesystem
        );

        $expected = new ConfigCollection();
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-common/composer.json'),
                $filesystem
            )
        );
        $expected->add(
            ConfigFactory::build(
                codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json'),
                $filesystem
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
