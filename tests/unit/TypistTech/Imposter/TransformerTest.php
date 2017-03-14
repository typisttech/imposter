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

    protected function _before()
    {
        $this->tester->copyDir(codecept_data_dir('fake-vendor'), codecept_data_dir('tmp-vendor'));
        $this->dummyFile = codecept_data_dir('tmp-vendor/dummy/dummy/DummyClass.php');
    }

    protected function _after()
    {
        $this->tester->deleteDir(codecept_data_dir('tmp-vendor'));
    }

    /**
     * @tests
     * @covers ::run
     * @covers ::prefix
     * @covers ::replace
     */
    public function it_prefixes_namespace()
    {
        $tester = $this->tester;

        $transformer = new Transformer($this->dummyFile, 'MyPlugin\Vendor', new Filesystem);
        $transformer->run();

        $tester->openFile($this->dummyFile);
        $tester->dontSeeInThisFile('namespace Dummy');
        $tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy\File;');
    }

    /**
     * @tests
     * @covers ::run
     * @covers ::prefix
     * @covers ::replace
     */
    public function it_prefixes_uses()
    {
        $tester = $this->tester;

        $transformer = new Transformer($this->dummyFile, 'MyPlugin\Vendor', new Filesystem);
        $transformer->run();

        $tester->openFile($this->dummyFile);

        $tester->dontSeeInThisFile('use Dummy');
        $tester->dontSeeInThisFile('use OtherDummy');
        $tester->dontSeeInThisFile('use AnotherDummy');

        $tester->seeInThisFile('use MyPlugin\Vendor\Dummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\OtherDummy\SubOtherDummy;');
        $tester->seeInThisFile('use MyPlugin\Vendor\AnotherDummy\{');
    }
}
