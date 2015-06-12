<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Withdrawal;
use Mabes\Entity\WithdrawalRepository;
use Mabes\Service\Command\WithdrawalMarkAsDoneCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WithdrawalMarkAsDoneService
{
    /**
     * @var WithdrawalRepository
     */
    private $withdrawal_repository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    public function __construct(
        WithdrawalRepository $withdrawal_repository,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->withdrawal_repository = $withdrawal_repository;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof WithdrawalMarkAsDoneCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->withdrawal_repository);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $withdrawal = $this->withdrawal_repository->findOneBy(
            [
                "withdrawal_id" => $command->getWithdrawalId()
            ]
        );

        $withdrawal->setStatus(Withdrawal::STATUS_PROCESSED);

        $this->withdrawal_repository->save($withdrawal);

        $data = [
            "email" => $withdrawal->getClient()->getEmail(),
            "account_id" => $withdrawal->getClient()->getAccountId(),
            "full_name" => $withdrawal->getClient()->getFullName(),
            "ticket" => $withdrawal->getWithdrawalId(),
            "amount" => $withdrawal->getAmount(),
            "bank_name" => $withdrawal->getClient()->getBankName(),
            "account_number" => $withdrawal->getClient()->getAccountNumber(),
            "account_holder" => $withdrawal->getClient()->getAccountHolder(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("admin.withdrawal.processed", [$data]);

        return true;
    }
}

// EOF
