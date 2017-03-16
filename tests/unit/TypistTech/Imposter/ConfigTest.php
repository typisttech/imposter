<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\Config
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string
     */
    private $json;

    /**
     * @var string
     */
    private $tmpVendor;

    /**
     * @var Config
     */
    private $config;

    /**
     * @covers ::getRequires
     */
    public function testGetRequires()
    {
        $expected = [
            'dummy/dummy',
            'dummy/dummy-psr4',
        ];

        $actual = $this->config->getRequires();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::getRequires
     */
    public function testExcludeImposter()
    {
        $actual = $this->config->getRequires();

        $this->assertNotContains('typisttech/imposter', $actual);
    }

    /**
     * @covers ::getAutoloads
     */
    public function testGetAutoloads()
    {
        $actual = $this->config->getAutoloads();

        $expected = [
            codecept_data_dir('i-am-simple-string'),
            codecept_data_dir('i-am-single-array'),
            codecept_data_dir('i-am-array-1'),
            codecept_data_dir('i-am-array-2'),
            codecept_data_dir('i-am-object-simple-string'),
            codecept_data_dir('i-am-object-single-array-single'),
            codecept_data_dir('i-am-object-single-array-1'),
            codecept_data_dir('i-am-object-single-array-2'),
            codecept_data_dir('i-am-object-array-single'),
            codecept_data_dir('i-am-object-array-1'),
            codecept_data_dir('i-am-object-array-2'),
            codecept_data_dir('i-am-object-array-3'),
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::getAutoloads
     */
    public function testGetAutoloadsInVendorDir()
    {
        $config = ConfigFactory::read($this->tmpVendor . '/dummy/dummy-psr4/composer.json', new Filesystem);

        $actual = $config->getAutoloads();

        $expected = [
            $this->tmpVendor . '/dummy/dummy-psr4/src/',
        ];

        $this->assertSame($expected, $actual);
    }

    protected function _before()
    {
        $this->json      = codecept_data_dir('composer.json');
        $this->tmpVendor = codecept_data_dir('tmp-vendor');
        $this->config    = ConfigFactory::read($this->json, new Filesystem);
    }
}
