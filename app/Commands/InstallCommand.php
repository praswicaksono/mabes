<?php
/**
 * Created by PhpStorm.
 * User: awalin
 * Date: 12/01/15
 * Time: 12:11
 */

namespace Mabes\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mabes\Entity\Staff;

class InstallCommand extends BaseCommand{
    protected function configure(){
        $this->setName("install")
            ->setDescription("First Initiation");
    }

    protected function execute(InputInterface $input,OutputInterface $output){
        $this->initStaff();
    }

    protected function initStaff(){
        $staff = new Staff();
        $staff->setUsername("administrator");
        $staff->setPassword("Blink182");

        $this->slim_app->em->persist($staff);
        $this->slim_app->em->flush();
    }

} 