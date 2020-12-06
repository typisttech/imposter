<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;
use RuntimeException;
use SplFileInfo;

/**
 * @coversDefaultClass \TypistTech\Imposter\Filesystem
 */
class FilesystemTest extends Unit
{
    /**
     * @var \TypistTech\Imposter\UnitTester
     */
    protected $tester;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function testDirname()
    {
        $expected = codecept_data_dir('tmp-vendor/dummy/dummy');
        $path = $expected . '/composer.json';

        $actual = $this->filesystem->dirname($path);

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testGet()
    {
        $path = codecept_data_dir('composer.json');

        $actual = $this->filesystem->get($path);

        $expected = file_get_contents($path);

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testGetNotExist()
    {
        $path = codecept_data_dir('NotExist.json');

        $expected = new RuntimeException('File does not exist at path ' . $path);

        $this->tester->expectThrowable($expected, function () use ($path) {
            $this->filesystem->get($path);
        });
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testIsFile()
    {
        $path = codecept_data_dir('composer.json');

        $actual = $this->filesystem->isFile($path);

        $this->assertTrue($actual);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testIsFileNotExist()
    {
        $path = codecept_data_dir('NotExist.json');

        $actual = $this->filesystem->isFile($path);

        $this->assertFalse($actual);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testIsDir()
    {
        $path = codecept_data_dir();

        $actual = $this->filesystem->isDir($path);

        $this->assertTrue($actual);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testIsDirNotExist()
    {
        $path = codecept_data_dir('NotExist/');

        $actual = $this->filesystem->isDir($path);

        $this->assertFalse($actual);
    }

    public function testIsInstanceOfFilesystemInterface()
    {
        $this->assertInstanceOf(FilesystemInterface::class, $this->filesystem);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testPut()
    {
        $path = codecept_data_dir('tmp-vendor/composer.json');
        $content = 'some content';

        $this->filesystem->put($path, $content);

        $this->tester->openFile($path);
        $this->tester->seeFileContentsEqual($content);
    }

    /**
     * @covers \TypistTech\Imposter\Filesystem
     */
    public function testsAllFiles()
    {
        $path = codecept_data_dir('tmp-vendor/dummy/dummy-psr4');

        $actual = $this->filesystem->allFiles($path);

        $actualRealPaths = array_map(function (SplFileInfo $file) {
            return $file->getRealPath();
        }, $actual);

        $expects = [
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/composer.json'),
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/DummyOne.php'),
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/DummyTwo.php'),
            codecept_data_dir('tmp-vendor/dummy/dummy-psr4/src/Sub/DummyOne.php'),
        ];

        foreach ($expects as $expected) {
            $this->assertContains($expected, $actualRealPaths);
        }
    }

    protected function _before()
    {
        $this->filesystem = new Filesystem();
    }
}
