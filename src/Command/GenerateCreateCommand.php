<?php

namespace SlayerBirden\Command;

use SlayerBirden\Dumper\FileDumper;
use SlayerBirden\Parser\DirectoryParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCreateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('diff:create')
            ->setDescription('Generate "create" diff for a folder')
            ->addArgument(
                'folder',
                InputArgument::REQUIRED,
                'Please specify a folder'
            )
            ->addArgument(
                'directives',
                InputArgument::REQUIRED,
                'Name of directives file?'
            )
            ->addArgument(
                'ignores',
                InputArgument::OPTIONAL,
                'Set ignores'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = new DirectoryParser();
        $files = $parser->parse($input->getArgument('folder'));
        if ($ignores = $input->getArgument('ignores')) {
            $ignores = explode(',', $ignores);
            foreach ($ignores as $ignore) {
                if (($key = array_search($ignore, array_map(function ($row) {
                        return $row[2];
                    }, $files))) !== false) {
                    unset($files[$key]);
                }
            }
        }
        $dumper = new FileDumper($input->getArgument('directives'));
        $dumper->dump($files);
        $output->writeln('<info>Directives are dumped successfully!</info>');
    }
}
