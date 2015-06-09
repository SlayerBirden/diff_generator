<?php

namespace SlayerBirden\Parser;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class DirectoryParserTest extends \PHPUnit_Framework_TestCase
{
    /** @var vfsStreamDirectory */
    protected $root;

    public function setUp()
    {
        $this->root = vfsStream::setup('root');
    }

    /**
     * @test
     */
    public function parse()
    {
        vfsStream::newFile('file1', '644')->setContent("test file1")->at($this->root);
        vfsStream::newFile('file2', '644')->setContent("test file1")->at($this->root);

        $parser = new DirectoryParser();

        $this->assertEquals([
            ['add', 'file1', 'file1'],
            ['add', 'file2', 'file2'],
        ], $parser->parse(vfsStream::url('root')));
    }
}
