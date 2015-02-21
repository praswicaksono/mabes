<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\StaffRepository;
use Mabes\Service\Command\AuthCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthService
{
    /**
     * @var StaffRepository
     */
    private $staff_repository;

    /**
     * @var AuthPasswordService
     */
    private $auth_password_service;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    public function __construct(
        StaffRepository $staff_repository,
        AuthPasswordService $auth_password_service,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->staff_repository = $staff_repository;
        $this->auth_password_service = $auth_password_service;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof AuthCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->staff_repository);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $staff = $this->staff_repository->findOneBy(["username" => $command->getUsername()]);
        $this->auth_password_service->setRawPassword($command->getPassword());
        $this->auth_password_service->setPassword($staff->getPassword());

        if (! $this->auth_password_service->auth()) {
            throw new \DomainException("Password yang anda masukkan salah");
        }

        return true;
    }
}

// EOF
