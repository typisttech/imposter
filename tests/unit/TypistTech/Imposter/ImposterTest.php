<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;
use Mockery;

/**
 * @coversDefaultClass \TypistTech\Imposter\Imposter
 */
class ImposterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testRunTransformOnAllAutoloadPaths()
    {
        $this->configCollection->shouldReceive('getAutoloads')
                               ->once()
                               ->andReturn([
                                   'path/to/dir',
                                   'path/to/file.php',
                               ]);
        $this->transformer->shouldReceive('transform')
                          ->once()
                          ->with('path/to/dir');
        $this->transformer->shouldReceive('transform')
                          ->once()
                          ->with('path/to/file.php');

        $this->imposter->run();
    }

    protected function _before()
    {
        $this->configCollection = Mockery::mock(ConfigCollection::class . '[getAutoloads]');
        $this->transformer      = Mockery::mock(Transformer::class . '[transform]', ['My\Prefix', new Filesystem]);
        $this->imposter         = new Imposter($this->configCollection, $this->transformer);
    }

    protected function _after()
    {
    }
}
