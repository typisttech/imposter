<?php
namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;
use UnexpectedValueException;

/**
 * @coversDefaultClass \TypistTech\Imposter\ProjectConfig
 */
class ProjectConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

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

    public function testsGetImposterNamespace()
    {
        $json   = codecept_data_dir('composer.json');
        $config = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = 'TypistTech\Imposter\Vendor';

        $actual = $config->getImposterNamespace();

        $this->assertSame($expected, $actual);
    }

    public function testsGetImposterNamespaceThrowsUnexpectedValueException()
    {
        $json   = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $config = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = new UnexpectedValueException('Imposter namespace is empty');

        $this->tester->expectException($expected, function () use ($config) {
            $config->getImposterNamespace();
        });
    }
}
