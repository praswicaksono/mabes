<?php


namespace Mabes\Service;

use Evenement\EventEmitter;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\ClaimRebate;
use Mabes\Entity\ClaimRebateRepository;
use Mabes\Entity\MemberRepository;
use Mabes\Service\Command\ClaimRebateCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClaimRebateService
{
    /**
     * @var MemberRepository
     */
    private $member_repo;

    /**
     * @var MemberRepository
     */
    private $claim_rebate_repo;

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
        ClaimRebateRepository $claim_rebate_repo,
        ValidatorInterface $validator,
        EventEmitter $event_emitter
    ) {
        $this->member_repo = $member_repo;
        $this->claim_rebate_repo = $claim_rebate_repo;
        $this->validator = $validator;
        $this->event_emitter = $event_emitter;
    }

    public function execute(CommandInterface $command)
    {
        if (! $command instanceof ClaimRebateCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);
        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = $this->member_repo->findOneBy(["account_id" => $command->getAccountId()]);

        $claim_rebate = new ClaimRebate();
        $claim_rebate->setMember($member);
        $claim_rebate->setMt4Account($command->getMt4Account());
        $claim_rebate->setType($command->getType());

        $this->claim_rebate_repo->save($claim_rebate);

        $data = [
            "email" => $member->getEmail(),
            "account_id" => $member->getAccountId(),
            "fullname" => $member->getFullName(),
            "type" => $claim_rebate->getType(),
            "mt4_account" => $claim_rebate->getMt4Account(),
            "bank_name" => $member->getBankName(),
            "account_number" => $member->getAccountNumber(),
            "account_holder" => $member->getAccountHolder(),
            "date" => date("Y-m-d H:i:s")
        ];

        $this->event_emitter->emit("claim.rebate.created", [$data]);

        return true;
    }
}

// EOF
