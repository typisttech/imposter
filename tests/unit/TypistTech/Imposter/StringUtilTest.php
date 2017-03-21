<?php

namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\StringUtil
 */
class StringUtilTest extends \Codeception\Test\Unit
{
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

    /**
     * @covers \TypistTech\Imposter\StringUtil::ensureDoubleBackwardSlash
     */
    public function testEnsureDoubleBackwardSlash1()
    {
        $actual = StringUtil::ensureDoubleBackwardSlash('my\\foo');

        $this->assertSame('my\\\\foo\\\\', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::ensureDoubleBackwardSlash
     */
    public function testEnsureDoubleBackwardSlash2()
    {
        $actual = StringUtil::ensureDoubleBackwardSlash('my\\\\foo\\');

        $this->assertSame('my\\\\foo\\\\', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil::ensureDoubleBackwardSlash
     */
    public function testEnsureDoubleBackwardSlash3()
    {
        $actual = StringUtil::ensureDoubleBackwardSlash('my\\foo\\\\');

        $this->assertSame('my\\\\foo\\\\', $actual);
    }
}
