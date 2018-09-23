<?php
declare(strict_types=1);

namespace TypistTech\Imposter;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\Imposter\ArrayUtil
 */
class ArrayUtilTest extends Unit
{
    /**
     * @covers \TypistTech\Imposter\ArrayUtil
     */
    public function testFlatten()
    {
        $array = [
            ['one'],
            ['two'],
            [
                'three',
                ['four'],
            ],
        ];

        $actual = ArrayUtil::flatten($array);

        $expected = [
            'one',
            'two',
            'three',
            ['four'],
        ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers \TypistTech\Imposter\ArrayUtil
     */
    public function testFlattenMap()
    {
        $array = [
            ['one'],
            ['two'],
            [
                'three',
                ['four'],
            ],
        ];

        $actual = ArrayUtil::flattenMap(function (array $element) {
            $element[0] .= '123';

            return $element;
        }, $array);

        $expected = [
            'one123',
            'two123',
            'three123',
            ['four'],
        ];

        $this->assertSame($expected, $actual);
    }
}
