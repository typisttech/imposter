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

    public function testPrefixNamespace()
    {
        $tester = $this->tester;

        $transformer = new Transformer('MyPlugin\Vendor', new Filesystem);
        $transformer->transform($this->dummyFile);

        $tester->openFile($this->dummyFile);
        $tester->dontSeeInThisFile('namespace Dummy');
        $tester->seeInThisFile('namespace MyPlugin\Vendor\Dummy\File;');
    }

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
