<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigCollectionFactory
 */
class ConfigCollectionFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @covers \TypistTech\Imposter\ConfigCollectionFactory
     */
    public function testForProject()
    {
        $filesystem    = new Filesystem;
        $projectConfig = ConfigFactory::buildProjectConfig(
            codecept_data_dir('composer.json'),
            $filesystem
        );

        $actual = ConfigCollectionFactory::forProject(
            $projectConfig,
            codecept_data_dir('tmp-vendor/'),
            $filesystem
        );

        $expected = new ConfigCollection;
        $expected->add($projectConfig);
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
                codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json'),
                $filesystem
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
