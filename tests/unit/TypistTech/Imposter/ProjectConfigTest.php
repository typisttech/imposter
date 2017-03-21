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

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetExcludes()
    {
        $json          = codecept_data_dir('composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = [
            'typisttech/imposter',
            'dummy/dummy-excluded',
        ];

        $actual = $projectConfig->getExcludes();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetExcludesDefault()
    {
        $json          = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = [
            'typisttech/imposter',
        ];

        $actual = $projectConfig->getExcludes();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetImposterNamespace()
    {
        $json          = codecept_data_dir('composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = 'TypistTech\Imposter\Vendor';

        $actual = $projectConfig->getImposterNamespace();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetImposterNamespaceThrowsUnexpectedValueException()
    {
        $json          = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = new UnexpectedValueException('Imposter namespace is empty');

        $this->tester->expectException($expected, function () use ($projectConfig) {
            $projectConfig->getImposterNamespace();
        });
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetVendorDir()
    {
        $json          = codecept_data_dir('composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = codecept_data_dir('tmp-vendor/');

        $actual = $projectConfig->getVendorDir();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsGetVendorDirWithDefaultFallback()
    {
        $json          = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/vendor/');

        $actual = $projectConfig->getVendorDir();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsIsAnInstanceOfConfig()
    {
        $json          = codecept_data_dir('composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $this->assertInstanceOf(ProjectConfig::class, $projectConfig);
        $this->assertInstanceOf(Config::class, $projectConfig);
    }

    /**
     * @covers \TypistTech\Imposter\ProjectConfig
     */
    public function testsSetExtraExcludes()
    {
        $json          = codecept_data_dir('tmp-vendor/dummy/dummy-dependency/composer.json');
        $projectConfig = ConfigFactory::buildProjectConfig($json, new Filesystem);

        $expected = [
            'typisttech/imposter',
            'exclude/me',
        ];

        $projectConfig->setExtraExcludes(['exclude/me']);
        $actual = $projectConfig->getExcludes();

        $this->assertSame($expected, $actual);
    }
}
