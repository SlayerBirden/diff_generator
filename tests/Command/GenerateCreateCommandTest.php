<?php

namespace SlayerBirden\Command;

use org\bovigo\vfs\vfsStream;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateCreateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testExecuteFlow()
    {
        $app = new Application();
        $app->add(new GenerateCreateCommand());

        $root = vfsStream::setup('root');
        vfsStream::newFile('directives.csv')->at($root);
        $testDir = vfsStream::newDirectory('test')->at($root);
        vfsStream::newFile('testfile')->at($testDir);

        $command = $app->find('diff:create');
        $tester = new CommandTester($command);

        $tester->execute(array(
            'command' => $command->getName(),
            'folder' => vfsStream::url('root/test'),
            'directives' => vfsStream::url('root/directives.csv'),
        ));

        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertContains('Directives are dumped successfully!', $tester->getDisplay());
    }
    /**
     * @test
     */
    public function testExecuteFlowWithIgnores()
    {
        $app = new Application();
        $app->add(new GenerateCreateCommand());

        $root = vfsStream::setup('root');
        vfsStream::newFile('directives.csv')->at($root);
        $testDir = vfsStream::newDirectory('test')->at($root);
        vfsStream::newFile('testfile1')->at($testDir);
        vfsStream::newFile('testfile2')->at($testDir);
        vfsStream::newFile('testfile3')->at($testDir);

        $command = $app->find('diff:create');
        $tester = new CommandTester($command);

        $tester->execute(array(
            'command' => $command->getName(),
            'folder' => vfsStream::url('root/test'),
            'directives' => vfsStream::url('root/directives.csv'),
            'ignores' => 'testfile1,testfile2',
        ));

        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertContains('Directives are dumped successfully!', $tester->getDisplay());

        $reader = new \SplFileObject(vfsStream::url('root/directives.csv'));

        $actual = [];
        while ($reader->eof() === false) {
            $actual[] = $reader->fgetcsv();
        }
        $this->assertEquals([
            ['add', 'testfile3', 'testfile3']
        ], $actual);
    }
}
