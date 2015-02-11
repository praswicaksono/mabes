<?php


namespace Mabes\Commands;

use Mabes\Config\DummyData;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends BaseCommand
{
    protected $dummy;

    public function __construct()
    {
        parent::__construct();

        $dummy = new DummyData();
        $this->dummy = $dummy->getDummyData();
    }

    protected function configure()
    {
        $this->setName("init")
            ->setDescription("First Initiate Dummy Data");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->dummy as $key => $value) {
            foreach ($value as $index => $data) {
                $isset = $this->slim_app->em->getRepository($key)->findOneBy([key($data) => $data[key($data)]]);
                if ($isset === null) {
                    $class = new $key;
                    $class->massAssignment($data);
                    $this->slim_app->em->persist($class);
                    $this->slim_app->em->flush();
                }
            }
        }
    }
}

// EOF
