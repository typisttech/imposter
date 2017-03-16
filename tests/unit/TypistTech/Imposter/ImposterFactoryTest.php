<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ImposterFactory
 */
class ImposterFactoryTest extends \Codeception\Test\Unit
{
    public function testFor()
    {
        $json       = codecept_data_dir('composer.json');
        $vendorDir  = codecept_data_dir('tmp-vendor');
        $filesystem = new Filesystem;

        $projectConfig    = ConfigFactory::buildProjectConfig($json, $filesystem);
        $configCollection = ConfigCollectionFactory::forProject($projectConfig, $vendorDir, $filesystem);
        $transformer      = new Transformer('TypistTech\Imposter\Vendor', $filesystem);

        $actual = ImposterFactory::forProject(codecept_data_dir());

        $expected = new Imposter($configCollection, $transformer);

        $this->assertEquals($expected, $actual);
    }
}
