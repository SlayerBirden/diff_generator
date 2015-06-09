<?php

namespace SlayerBirden\Util;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider directivesProvider
     * @param array $directives
     * @param array $ignores
     * @param array $expected
     */
    public function testFilter($directives, $ignores, $expected)
    {
        $filter = new Filter();
        $actual = $filter->getFiltered($directives, $ignores);
        $this->assertEquals($expected, $actual, "expected: " . json_encode($expected) . "; actual: " . json_encode($actual));
    }

    /**
     * @return array
     */
    public function directivesProvider()
    {
        return [
            [
                [
                    ['add', 'app/code/file1', 'app/code/file1'],
                    ['add', 'app/js/file2', 'app/js/file2'],
                    ['add', 'index', 'index'],
                ],
                ['index', '*/file2'],
                [
                    ['add', 'app/code/file1', 'app/code/file1'],
                ]
            ],
            [
                [
                    ['add', 'app/code/file1', 'app/code/file1'],
                    ['add', 'app/js/file2', 'app/js/file2'],
                    ['add', 'index', 'index'],
                ],
                ['app/*'],
                [
                    ['add', 'index', 'index'],
                ]
            ],
        ];
    }
}
