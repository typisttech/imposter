<?php

namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\ConfigCollection
 */
class ConfigCollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var Config
     */
    private $config1;

    /**
     * @var Config
     */
    private $config2;

    /**
     * @var ConfigCollection
     */
    private $configCollection;

    /**
     * @covers \TypistTech\Imposter\ConfigCollection
     */
    public function testAddConfigsUniqueness()
    {
        $this->configCollection->add($this->config1);
        $this->configCollection->add($this->config1);

        $actual   = $this->configCollection->all();
        $expected = [
            $this->config1->getPackageDir() => $this->config1,
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigCollection
     */
    public function testAddMultipleConfigs()
    {
        $this->configCollection->add($this->config1);
        $this->configCollection->add($this->config2);

        $actual   = $this->configCollection->all();
        $expected = [
            $this->config1->getPackageDir() => $this->config1,
            $this->config2->getPackageDir() => $this->config2,
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigCollection
     */
    public function testAddOneConfig()
    {
        $this->configCollection->add($this->config1);

        $actual   = $this->configCollection->all();
        $expected = [
            $this->config1->getPackageDir() => $this->config1,
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigCollection
     */
    public function testGetAutoloads()
    {
        $this->configCollection->add($this->config1);
        $this->configCollection->add($this->config2);

        $actual = $this->configCollection->getAutoloads();

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
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/'),
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ConfigCollection
     */
    public function testGetAutoloadsUniqueness()
    {
        $this->configCollection->add($this->config1);
        $this->configCollection->add($this->config2);
        $this->configCollection->add($this->config1);
        $this->configCollection->add($this->config2);

        $actual = $this->configCollection->getAutoloads();

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
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/'),
        ];

        $this->assertSame($expected, $actual);
    }

    protected function _before()
    {
        $filesystem    = new Filesystem;
        $json1         = codecept_data_dir('composer.json');
        $json2         = codecept_data_dir('tmp-vendor/dummy/dummy-psr4/composer.json');
        $this->config1 = ConfigFactory::build($json1, $filesystem);
        $this->config2 = ConfigFactory::build($json2, $filesystem);

        $this->configCollection = new ConfigCollection;
    }
}
