<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigFactory
 */
class ConfigFactoryTest extends \Codeception\Test\Unit
{
    public function testRead()
    {
        $json       = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $actual   = ConfigFactory::read($json, new Filesystem);
        $expected = new Config(
            codecept_data_dir(),
            json_decode(
                $filesystem->get($json),
                true
            )
        );

        $this->assertEquals($expected, $actual);
    }
}
