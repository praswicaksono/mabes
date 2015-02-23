<?php


namespace Mabes\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mabes\Service\Command\CreateStaffCommand as Command;
class CreateStaffCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("create:staff")
            ->setDescription("your your staff via command line")
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
        try {
            $create_staff_service = $this->slim_app->container->get("CreateStaffService");

            $command = new Command();
            $command->massAssignment($input->getArguments());

            $create_staff_service->execute($command);

            $output->write("Staff berhasil ditambah");
        } catch (\DomainException $e) {
            $output->write($e->getMessage());
        }
    }
}

// EOF
