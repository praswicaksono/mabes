<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Entity\Staff;
use Mabes\Entity\StaffRepository;
use Mabes\Service\Command\CreateStaffCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateStaffService
{
    private $staff_repository;

    private $hash_service;

    private $validator;

    private $event_emitter;

    public function __construct(
        StaffRepository $staff_repository,
        HashService $hash_service,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->staff_repository = $staff_repository;
        $this->hash_service = $hash_service;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CreateStaffCommand $command)
    {
        if (! $command instanceof CreateStaffCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->staff_repository);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $staff = new Staff();
        $this->hash_service->setRawPassword($command->getPassword());
        $staff->setUsername($command->getUsername());
        $staff->setPassword($this->hash_service->hash());

        $this->staff_repository->save($staff);

        return true;
    }
}

// EOF
