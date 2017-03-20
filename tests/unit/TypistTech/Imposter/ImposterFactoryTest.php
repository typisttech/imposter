<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ImposterFactory
 */
class ImposterFactoryTest extends \Codeception\Test\Unit
{
    public function testForProject()
    {
        $json       = codecept_data_dir('composer.json');
        $filesystem = new Filesystem;

        $projectConfig    = ConfigFactory::buildProjectConfig($json, $filesystem);
        $configCollection = ConfigCollectionFactory::forProject($projectConfig, $filesystem);
        $transformer      = new Transformer('TypistTech\Imposter\Vendor', $filesystem);

        $actual = ImposterFactory::forProject(codecept_data_dir());

        $expected = new Imposter($configCollection, $transformer);

        $this->assertEquals($expected, $actual);
    }
}
