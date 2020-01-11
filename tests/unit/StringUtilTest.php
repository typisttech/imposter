<?php

declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Imposter\StringUtil
 */
class StringUtilTest extends Unit
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
