<?php

namespace TypistTech\Imposter;

use Illuminate\Filesystem\Filesystem;

/**
 * @coversDefaultClass \TypistTech\Imposter\Transformer
 */
class TransformerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var string
     */
    private $dummyFile;

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testPrefixNamespace()
    {
        $tester = $this->tester;

        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);
        $transformer->transform($this->dummyFile);

        $tester->openFile($this->dummyFile);
        $tester->dontSeeInThisFile('namespace Dummy');
        $tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy\File;');
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformAllFilesInADirectory()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);
        $transformer->transform(codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src'));

        $this->assertTransformed(codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/DummyOne.php'));
        $this->assertTransformed(codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/DummyTwo.php'));
        $this->assertTransformed(codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/Sub/DummyOne.php'));
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    private function assertTransformed(string $path)
    {
        $tester = $this->tester;

        $tester->openFile($path);
        $tester->dontSeeInThisFile('namespace Dummy');
        $tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy\\');
        $tester->dontSeeInThisFile('use Dummy');
        $tester->dontSeeInThisFile('use OtherDummy');
        $tester->dontSeeInThisFile('use AnotherDummy');
        $tester->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testsPrefixUses()
    {
        $tester = $this->tester;

        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);
        $transformer->transform($this->dummyFile);

        $tester->openFile($this->dummyFile);

        $tester->dontSeeInThisFile('use Dummy');
        $tester->dontSeeInThisFile('use OtherDummy');
        $tester->dontSeeInThisFile('use AnotherDummy');

        $tester->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }

    protected function _before()
    {
        $this->dummyFile = codecept_data_dir('tmp-vendor/dummy/dummy/DummyClass.php');
    }
}
