<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\ProjectConfig
 */
class ProjectConfigTest extends \Codeception\Test\Unit
{
    public function testsIsAnInstanceOfConfig()
    {
        $json   = codecept_data_dir('composer.json');
        $config = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $this->assertInstanceOf(ProjectConfig::class, $config);
        $this->assertInstanceOf(Config::class, $config);
    }

    public function testsGetVendorDirWithDefaultFallback()
    {
        $json   = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $config = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/vendor/');

        $actual = $config->getVendorDir();

        $this->assertSame($expected, $actual);
    }

    public function testsGetVendorDir()
    {
        $json   = codecept_data_dir('composer.json');
        $config = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = codecept_data_dir('tmp-vendor/');

        $actual = $config->getVendorDir();

        $this->assertSame($expected, $actual);
    }
}
