<?php
declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Imposter\Transformer
 */
class TransformerTest extends Unit
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
    public function testTransformTwiceHasNoEffects()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);
        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->seeFileContentsEqual(file_get_contents(codecept_data_dir('tmp-vendor/Expected.php')));
    }

    /**
     * @covers \TypistTech\Imposter\Transformer
     */
    public function testTransform()
    {
        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);

        $transformer->transform($this->dummyFile);

        $this->tester->openFile($this->dummyFile);
        $this->tester->seeFileContentsEqual(file_get_contents(codecept_data_dir('tmp-vendor/Expected.php')));
    }

    protected function _before()
    {
        $this->dummyFile = codecept_data_dir('tmp-vendor/Dummy.php');
    }
}
