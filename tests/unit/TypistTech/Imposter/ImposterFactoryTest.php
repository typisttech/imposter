<?php

namespace TypistTech\Imposter;

use AspectMock\Test;
use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ImposterFactory
 */
class ImposterFactoryTest extends \Codeception\Test\Unit
{
    public function testForProject()
    {
        $filesystem = new Filesystem;

        $projectConfig    = ConfigFactory::buildProjectConfig(codecept_data_dir('composer.json'), $filesystem);
        $configCollection = ConfigCollectionFactory::forProject($projectConfig, $filesystem);
        $transformer      = new Transformer('TypistTech\Imposter\Vendor', $filesystem);

        $actual = ImposterFactory::forProject(codecept_data_dir());

        $expected = new Imposter($configCollection, $transformer);

        $this->assertEquals($expected, $actual);
    }

    public function testSetProjectConfigExtraExcludes()
    {
        $projectConfig = Test::double(
            ConfigFactory::buildProjectConfig(codecept_data_dir('composer.json'), new Filesystem),
            ['setExtraExcludes' => null]
        );
        Test::double(
            ConfigFactory::class,
            ['buildProjectConfig' => $projectConfig->getObject()]
        );

        ImposterFactory::forProject(codecept_data_dir(), ['my/exclude']);

        $projectConfig->verifyInvokedOnce('setExtraExcludes', [['my/exclude']]);
    }
}
