<?php
declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;
use Mockery;

/**
 * @coversDefaultClass \TypistTech\Imposter\Imposter
 */
class ImposterTest extends Unit
{
    private $configCollection;

    /**
     * @var Imposter
     */
    private $imposter;

    private $transformer;

    public function testConfigCollectionGetter()
    {
        $actual   = $this->imposter->getConfigCollection();
        $expected = $this->configCollection;

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
        $expected = $this->transformer;

        $this->assertSame($expected, $actual);
    }

    protected function _before()
    {
        $this->configCollection = Mockery::spy(ConfigCollection::class);
        $this->configCollection->allows('getAutoloads')
            ->withNoArgs()
            ->andReturn([
                'path/to/dir',
                'path/to/file.php',
            ]);

        $this->transformer = Mockery::spy(Transformer::class);
        $this->transformer->allows('transform')
            ->withNoArgs()
            ->andReturnNull();

        $this->imposter = new Imposter($this->configCollection, $this->transformer);
    }
}
