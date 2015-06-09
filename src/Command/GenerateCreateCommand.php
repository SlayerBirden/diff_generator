<?php

namespace SlayerBirden\Command;

use SlayerBirden\Dumper\FileDumper;
use SlayerBirden\Parser\DirectoryParser;
use SlayerBirden\Util\Filter;
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
            $filter = new Filter();
            $files = $filter->getFiltered($files, $ignores);
        }
        $dumper = new FileDumper($input->getArgument('directives'));
        $dumper->dump($files);
        $output->writeln('<info>Directives are dumped successfully!</info>');
    }
}
