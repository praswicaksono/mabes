<?php


namespace Mabes\Commands;

use Mabes\Entity\Member;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName("faker")
            ->setDescription("Add Fake Data");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $member = new Member();
        $member->setMemberId(1);
        $member->setFullName("Prasetyo");
        $member->setCountry("Indonesia");
        $member->setPhone("+62123456");
        $member->setEmail("john@doe.com");
        $member->setRegisterDate(new \DateTime());

        $this->slim_app->em->persist($member);

        $this->slim_app->em->flush();
    }
}

// EOF
