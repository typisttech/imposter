<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigFactory
 */
class ConfigFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @covers \TypistTech\Imposter\ConfigFactory
     */
    public function testBuild()
    {
        $json       = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $actual   = ConfigFactory::build($json, new Filesystem);
        $expected = new Config(
            codecept_data_dir(),
            json_decode(
                $filesystem->get($json),
                true
            )
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigFactory
     */
    public function testBuildProjectConfig()
    {
        $json       = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $actual   = ConfigFactory::buildProjectConfig($json, new Filesystem);
        $expected = new ProjectConfig(
            codecept_data_dir(),
            json_decode(
                $filesystem->get($json),
                true
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
