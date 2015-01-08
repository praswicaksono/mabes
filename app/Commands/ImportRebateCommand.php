<?php


namespace Mabes\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportRebateCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("import:rebate")
            ->setDescription("Import Rebate");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("hello world");
    }
}

// EOF
