<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\InvestorPassword;
use Mabes\Entity\InvestorPasswordRepository;
use Mabes\Entity\MemberRepository;
use Mabes\Service\Command\AddInvestorPasswordCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddInvestorPasswordService
{
    /**
     * @var MemberRepository
     */
    private $member_repo;

    /**
     * @var InvestorPasswordRepository
     */
    private $investor_password_repo;

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
        InvestorPasswordRepository $investor_password_repo,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->member_repo = $member_repo;
        $this->investor_password_repo = $investor_password_repo;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof AddInvestorPasswordCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);
        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = $this->member_repo->findOneBy(["account_id" => $command->getAccountId()]);

        $investor_password = new InvestorPassword();
        $investor_password->setInvestorPassword($command->getInvestorPassword());
        $investor_password->setMtAccount($command->getMt4Account());
        $investor_password->setAccountId($member);


        $this->investor_password_repo->save($investor_password);

        $data = [
            "email" => $member->getEmail(),
            "account_id" => $member->getAccountId(),
            "fullname" => $member->getFullName(),
            "mt4_account" => $investor_password->getMtAccount(),
            "investor_password" => $investor_password->getInvestorPassword(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("investor.password.created", [$data]);

        return true;
    }
}

// EOF
