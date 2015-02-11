<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\MemberRepository;
use Mabes\Entity\Withdrawal;
use Mabes\Entity\WithdrawalRepository;
use Mabes\Service\Command\CreateWithdrawalCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateWithdrawalService
{
    /**
     * @var MemberRepository
     */
    private $member_repo;

    /**
     * @var WithdrawalRepository
     */
    private $withdrawal_repo;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    public function __construct(
        MemberRepository $member_repo,
        WithdrawalRepository $withdrawal_repo,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->event_emitter = $event_emitter;
        $this->member_repo = $member_repo;
        $this->withdrawal_repo = $withdrawal_repo;
        $this->validator = $validator;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof CreateWithdrawalCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = $this->member_repo->findOneBy(["account_id" => $command->getAccountId()]);

        $withdrawal = new Withdrawal();
        $withdrawal->setClient($member);
        $withdrawal->setAmount($command->getAmount());
        $withdrawal->setStatus(Withdrawal::STATUS_OPEN);

        $this->withdrawal_repo->save($withdrawal);

        $data = [
            "email" => $member->getEmail(),
            "account_id" => $member->getAccountId(),
            "full_name" => $member->getFullName(),
            "ticket" => $withdrawal->getWithdrawalId(),
            "amount" => $withdrawal->getAmount(),
            "bank_name" => $member->getBankName(),
            "account_number" => $member->getAccountNumber(),
            "account_holder" => $member->getAccountHolder(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("withdrawal.created", [$data]);

        return (int) $withdrawal->getWithdrawalId();
    }
}

// EOF
