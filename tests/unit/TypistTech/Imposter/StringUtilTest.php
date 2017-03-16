<?php
namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\StringUtil
 */
class StringUtilTest extends \Codeception\Test\Unit
{
    public function testAddTrailingSlash()
    {
        $actual = StringUtil::addTrailingSlash('foo');

        $this->assertSame('foo/', $actual);
    }

    public function testAddTrailingSlashToSlashed()
    {
        $actual = StringUtil::addTrailingSlash('foo/');

        $this->assertSame('foo/', $actual);
    }
}
