<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Deposit;
use Mabes\Entity\DepositRepository;
use Mabes\Service\Command\DepositMarkAsFailedCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DepositMarkAsFailedService
{
    /**
     * @var DepositRepository
     */
    private $deposit_repository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    public function __construct(
        DepositRepository $deposit_repository,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->deposit_repository = $deposit_repository;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof DepositMarkAsFailedCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->deposit_repository);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $deposit = $this->deposit_repository->findOneBy(["deposit_id" => $command->getDepositId()]);

        $deposit->setStatus(Deposit::STATUS_FAILED);

        $this->deposit_repository->save($deposit);

        $data = [
            "email" => $deposit->getClient()->getEmail(),
            "ticket" => $deposit->getDepositId(),
            "full_name" => $deposit->getClient()->getFullName(),
            "account_id" => $deposit->getClient()->getAccountId(),
            "amount_idr" => $deposit->getAmountIdr(),
            "amount_usd" => $deposit->getAmountUsd(),
            "bank_name" => $deposit->getToBank(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("admin.deposit.failed", [$data]);

        return true;
    }
}

// EOF
