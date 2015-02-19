<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\MemberRepository;
use Mabes\Service\Command\CreateIslamicAccountCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateIslamicAccountService
{
    /**
     * @var MemberRepository
     */
    private $member_repo;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EventEmitter
     */
    private $event_emitter;

    public function __construct(MemberRepository $member_repo,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->member_repo = $member_repo;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof CreateIslamicAccountCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = $this->member_repo->findOneBy([
            "account_id" => $command->getAccountId()
        ]);

        $data = [
            "account_id" => $command->getAccountId(),
            "mt4_account" => $command->getMt4Account(),
            "fullname" => $member->getFullname(),
            "phone" => $member->getPhone(),
            "email" => $member->getEmail(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("akun.islami.created", [$data]);

        return true;
    }
}

// EOF
