<?php
declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigFactory
 */
class ConfigFactoryTest extends Unit
{
    /**
     * @covers \TypistTech\Imposter\ConfigFactory
     */
    public function testBuild()
    {
        $json = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $actual = ConfigFactory::build($json, new Filesystem);
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
        $json = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $actual = ConfigFactory::buildProjectConfig($json, new Filesystem);
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
