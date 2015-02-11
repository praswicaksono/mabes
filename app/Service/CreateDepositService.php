<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Deposit;
use Mabes\Entity\DepositRepository;
use Mabes\Entity\MemberRepository;
use Mabes\Service\Command\CreateDepositCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateDepositService
 * @package Mabes\Service
 */
class CreateDepositService
{
    /**
     * @var MemberRepository
     */
    private $member_repo;

    /**
     * @var DepositRepository
     */
    private $deposit_repo;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    /**
     * @param MemberRepository $member_repo
     * @param DepositRepository $deposit_repo
     * @param ValidatorInterface $validator
     * @param EventEmitter $event_emitter
     */
    public function __construct(
        MemberRepository $member_repo,
        DepositRepository $deposit_repo,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->member_repo = $member_repo;
        $this->deposit_repo = $deposit_repo;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    /**
     * @param CommandInterface $command
     * @return int
     */
    public function execute(CommandInterface $command)
    {
        if (! $command instanceof CreateDepositCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = $this->member_repo->findOneBy(["account_id" => $command->getAccountId()]);

        $deposit = new Deposit();
        $deposit->setClient($member);
        $deposit->setAmountIdr($command->getAmountIdr());
        $deposit->setToBank($command->getToBank());
        $deposit->setAmountUsd($command->getAmountUsd());
        $deposit->setStatus(Deposit::STATUS_OPEN);

        $this->deposit_repo->save($deposit);

        $data = [
            "email" => $member->getEmail(),
            "ticket" => $deposit->getDepositId(),
            "full_name" => $member->getFullName(),
            "account_id" => $member->getAccountId(),
            "amount_idr" => $deposit->getAmountIdr(),
            "amount_usd" => $deposit->getAmountUsd(),
            "bank_name" => $deposit->getToBank(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("deposit.created", [$data]);

        return (int) $deposit->getDepositId();
    }
}

// EOF
