<?php
namespace TypistTech\Imposter;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\Imposter\Imposter
 */
class ImposterTest extends \Codeception\Test\Unit
{
    /**
     * @var Imposter
     */
    private $imposter;

    private $configCollection;

    private $transformer;

    public function testConfigCollectionGetter()
    {
        $actual   = $this->imposter->getConfigCollection();
        $expected = $this->configCollection->getObject();

        $this->assertSame($expected, $actual);
    }

    public function testGetAutoloads()
    {
        $actual   = $this->imposter->getAutoloads();
        $expected = $this->configCollection->getAutoloads();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\Imposter
     */
    public function testRunTransformOnAllAutoloadPaths()
    {
        $this->imposter->run();

        $this->transformer->verifyInvoked('transform', ['path/to/dir']);
        $this->transformer->verifyInvoked('transform', ['path/to/file.php']);
        $this->transformer->verifyInvokedMultipleTimes('transform', 2);
    }

    public function testTransform()
    {
        $this->imposter->transform('my/path');

        $this->transformer->verifyInvokedOnce('transform', ['my/path']);
        $this->transformer->verifyInvokedMultipleTimes('transform', 1);
    }

    public function testTransformerGetter()
    {
        $actual   = $this->imposter->getTransformer();
        $expected = $this->transformer->getObject();

        $this->assertSame($expected, $actual);
    }

    protected function _before()
    {
        $this->configCollection = Test::double(
            new ConfigCollection,
            [
                'getAutoloads' => [
                    'path/to/dir',
                    'path/to/file.php',
                ],
            ]
        );

        $this->transformer = Test::double(
            Test::double(Transformer::class)->make(),
            ['transform' => null]
        );

        $this->imposter = new Imposter($this->configCollection->getObject(), $this->transformer->getObject());
    }
}
