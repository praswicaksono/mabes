<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Deposit;
use Mabes\Entity\DepositRepository;
use Mabes\Service\Command\DepositMarkAsDoneCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DepositMarkAsDoneService
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
        if (! $command instanceof DepositMarkAsDoneCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->deposit_repository);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $deposit = $this->deposit_repository->findOneBy(["deposit_id" => $command->getDepositId()]);

        $deposit->setStatus(Deposit::STATUS_PROCESSED);

        $this->deposit_repository->save($deposit);

        $this->event_emitter->emit("admin.deposit.processed");

        return true;
    }
}

// EOF
