<?php

namespace TypistTech\Imposter;

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
        $tester->dontSeeInThisFile('use Dummy');
        $tester->dontSeeInThisFile('use OtherDummy');
        $tester->dontSeeInThisFile('use AnotherDummy');

        $tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy\\');
        $tester->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformExcludesComposerNamespace()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->dontSeeInThisFile('MyPlugin\Vendor\Composer;');
        $this->tester->dontSeeInThisFile('MyPlugin\Vendor\Composer\\');

        $this->assertTransformed($this->dummyFile);
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformExcludesGlobalNamespace()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->dontSeeInThisFile('use MyPlugin\Vendor\RuntimeException;');
        $this->tester->seeInThisFile('use RuntimeException;');

        $this->assertTransformed($this->dummyFile);
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformExcludesGlobalNamespaceWithLeadingSlash()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->dontSeeInThisFile('use MyPlugin\Vendor\UnexpectedValueException;');
        $this->tester->dontSeeInThisFile('use MyPlugin\Vendor\\\\UnexpectedValueException;');
        $this->tester->dontSeeInThisFile('use \MyPlugin\Vendor\\\\UnexpectedValueException;');
        $this->tester->dontSeeInThisFile('use \MyPlugin\Vendor\UnexpectedValueException;');
        $this->tester->seeInThisFile('use \UnexpectedValueException;');

        $this->assertTransformed($this->dummyFile);
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformSingleLevelNamespace()
    {
        $path        = codecept_data_dir('tmp-vendor/dummy/dummy-excluded/DummyClass.php');
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($path);

        $this->tester->openFile($path);
        $this->tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy');
        $this->tester->dontSeeInThisFile('namespace Dummy;');
        $this->tester->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransformTwiceHasNoEffects()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);
        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->dontSeeInThisFile('MyPlugin\Vendor\MyPlugin\Vendor');

        $this->assertTransformed($this->dummyFile);
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
