<?php


namespace Mabes\Commands;

use Mabes\Entity\Member;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakerCommand extends BaseCommand
{
    private $members_data = array();

    public function __construct()
    {
        parent::__construct();

        $this->members_data = [
            [
                "member_id" => 1,
                "full_name" => "Prastyo Wicaksono",
                "country" => "Indonesia",
                "phone" => "+621234567",
                "email" => "john@doe.com",
                "register_date" => new \DateTime()
            ]
            , [
                "member_id" => 2,
                "full_name" => "Awalin Yudhana",
                "country" => "Indonesia",
                "phone" => "+62987654",
                "email" => "jack@kiss.com",
                "register_date" => new \DateTime()
            ]
        ];
    }

    protected function configure()
    {
        $this->setName("faker")
            ->setDescription("Add Fake Data");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->members_data as $member_data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Member", $member_data['member_id']);
            if ($isset === null) {
                $member = new Member();
                $member->massAssignment($member_data);

                $this->slim_app->em->persist($member);
                $this->slim_app->em->flush();
            }
        }

    }
}

// EOF
