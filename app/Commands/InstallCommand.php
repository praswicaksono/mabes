<?php


namespace Mabes\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Mabes\Entity\Staff;

class InstallCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("install")
            ->setDescription("Add first staff")
            ->addArgument(
                "username",
                InputArgument::REQUIRED,
                "Enter your username"
            )
            ->addArgument(
                "password",
                InputArgument::REQUIRED,
                "Enter your password"
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $staff = new Staff();
        $staff->setUsername($input->getArgument("username"));
        $staff->setPassword($input->getArgument("password"));

        $this->slim_app->em->persist($staff);
        $this->slim_app->em->flush();
    }
}

// EOF
