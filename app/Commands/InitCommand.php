<?php


namespace Mabes\Commands;

use Mabes\Entity\Staff;
use Mabes\Entity\Member;
use Mabes\Entity\Bank;
use Mabes\Entity\Deposit;
use Mabes\Entity\Withdrawal;
use Mabes\Entity\Transfer;
use Mabes\Config\DummyData;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class initCommand extends BaseCommand
{
    private $dummy;

    protected $member;

    protected $staff;

    protected $bank;

    protected $deposit;

    protected $withdrawal;

    protected $transfer;

    public function __construct()
    {
        parent::__construct();

        $this->dummy = new DummyData();
        $this->member = $this->dummy->getMember();
        $this->staff = $this->dummy->getStaff();
        $this->bank = $this->dummy->getBank();
        $this->deposit = $this->dummy->getDeposit();
        $this->withdrawal = $this->dummy->getWithdrawal();
        $this->transfer = $this->dummy->getTransfer();
    }

    protected function configure()
    {
        $this->setName("init")
            ->setDescription("First Initiate Dummy Data");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->insertDummyStaff();
        $this->insertDummyMember();
        $this->insertDummyBank();
        $this->insertDummyDeposit();
        $this->insertDummyWithdrawal();
        $this->insertDummyTransfer();
    }

    public function insertDummyStaff()
    {
        foreach ($this->staff as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Staff", $data['staff_id']);
            if ($isset === null) {
                $staff = new Staff();
                $staff->setUsername($data['staff_id']);
                $staff->setUsername($data['username']);
                $staff->setPassword($data['password']);
                $this->slim_app->em->persist($staff);
                $this->slim_app->em->flush();
            }
        }
    }

    public function insertDummyMember()
    {
        foreach ($this->member as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Member", $data['member_id']);
            if ($isset === null) {
                $member = new Member();
                $member->massAssignment($data);
                $this->slim_app->em->persist($member);
                $this->slim_app->em->flush();
            }
        }
    }

    public function insertDummyBank()
    {
        foreach ($this->bank as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Bank", $data['bank_id']);
            if ($isset === null) {
                $bank = new Bank();
                $bank->massAssignment($data);
                $this->slim_app->em->persist($bank);
                $this->slim_app->em->flush();
            }
        }
    }

    public function insertDummyDeposit()
    {
        foreach ($this->deposit as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Deposit", $data['deposit_id']);
            if ($isset === null) {

                $member = $this->slim_app->em->find("Mabes\\Entity\\Member", $this->member[0]['member_id']);
                $bank = $this->slim_app->em->find("Mabes\\Entity\\Bank", $this->bank[0]['bank_id']);

                $deposit = new Deposit();
                $deposit->massAssignment($data);
                $deposit->setClient($member);
                $deposit->setBank($bank);

                $this->slim_app->em->persist($deposit);
                $this->slim_app->em->flush();

            }
        }
    }

    public function insertDummyWithdrawal()
    {
        foreach ($this->withdrawal as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Withdrawal", $data['withdrawal_id']);
            if ($isset === null) {

                $member = $this->slim_app->em->find("Mabes\\Entity\\Member", $this->member[0]['member_id']);

                $withdrawal = new Withdrawal();
                $withdrawal->massAssignment($data);
                $withdrawal->setClient($member);

                $this->slim_app->em->persist($withdrawal);
                $this->slim_app->em->flush();
            }
        }
    }

    public function insertDummyTransfer(){
        foreach ($this->transfer as $data) {
            $isset = $this->slim_app->em->find("Mabes\\Entity\\Transfer", $data['transfer_id']);
            if ($isset === null) {

                $member_from = $this->slim_app->em->find("Mabes\\Entity\\Member", $this->member[0]['member_id']);
                $member_to = $this->slim_app->em->find("Mabes\\Entity\\Member", $this->member[1]['member_id']);

                $transfer = new Transfer();
                $transfer->massAssignment($data);
                $transfer->setFromLogin($member_from);
                $transfer->setToLogin($member_to);

                $this->slim_app->em->persist($transfer);
                $this->slim_app->em->flush();
            }
        }
    }
}

// EOF
