<?php
namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\StringUtil
 */
class StringUtilTest extends \Codeception\Test\Unit
{
    /**
     * @covers \TypistTech\Imposter\StringUtil
     */
    public function testAddTrailingSlash()
    {
        $actual = StringUtil::addTrailingSlash('foo');

        $this->assertSame('foo/', $actual);
    }

    /**
     * @covers \TypistTech\Imposter\StringUtil
     */
    public function testAddTrailingSlashToSlashed()
    {
        $actual = StringUtil::addTrailingSlash('foo/');

        $this->assertSame('foo/', $actual);
    }
}
