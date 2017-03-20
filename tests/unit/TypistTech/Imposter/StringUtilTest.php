<?php

namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\StringUtil
 */
class StringUtilTest extends \Codeception\Test\Unit
{
    /**
     * @covers \TypistTech\Imposter\StringUtil::addDoubleTrailingBackwardSlash
     */
    public function testAddDoubleTrailingBackwardSlash()
    {
        $actual = StringUtil::addDoubleTrailingBackwardSlash('my\\foo');

        $this->assertSame('my\\foo\\\\', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::addDoubleTrailingBackwardSlash
     */
    public function testAddDoubleTrailingBackwardSlashToBackwardSlashed()
    {
        $actual = StringUtil::addDoubleTrailingBackwardSlash('my\\foo\\');

        $this->assertSame('my\\foo\\\\', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::addDoubleTrailingBackwardSlash
     */
    public function testAddDoubleTrailingBackwardSlashToDoubleBackwardSlashed()
    {
        $actual = StringUtil::addDoubleTrailingBackwardSlash('my\\foo\\');

        $this->assertSame('my\\foo\\\\', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::addTrailingSlash
     */
    public function testAddTrailingSlash()
    {
        $actual = StringUtil::addTrailingSlash('my/foo');

        $this->assertSame('my/foo/', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::addTrailingSlash
     */
    public function testAddTrailingSlashToSlashed()
    {
        $actual = StringUtil::addTrailingSlash('my/foo/');

        $this->assertSame('my/foo/', $actual);
    }
}
