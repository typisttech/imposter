<?php
namespace TypistTech\Imposter;

/**
 * @coversDefaultClass \TypistTech\Imposter\ArrayUtil
 */
class ArrayUtilTest extends \Codeception\Test\Unit
{
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
