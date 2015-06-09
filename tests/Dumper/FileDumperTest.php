<?php

namespace SlayerBirden\Dumper;

use org\bovigo\vfs\vfsStream;

class FileDumperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function dump()
    {
        $root = vfsStream::setup('root');
        vfsStream::newFile('directives.csv')->at($root);

        $dumper = new FileDumper(vfsStream::url('root/directives.csv'));

        $values = [
            ['add', 'file1', 'file1'],
            ['add', 'file2', 'file2'],
        ];

        $dumper->dump($values);

        $reader = new \SplFileObject(vfsStream::url('root/directives.csv'));

        $actual = [];
        while ($reader->eof() === false) {
            $actual[] = $reader->fgetcsv();
        }

        $this->assertEquals($values, $actual);
    }
}
