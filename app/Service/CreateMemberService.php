<?php


namespace Mabes\Service;

use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Member;
use Mabes\Entity\MemberRepository;
use Mabes\Service\Command\CreateMemberCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateMemberService
 * @package Mabes\Service
 */
class CreateMemberService
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
     * @param MemberRepository $member_repo
     * @param ValidatorInterface $validator
     */
    public function __construct(MemberRepository $member_repo, ValidatorInterface $validator)
    {
        $this->member_repo = $member_repo;
        $this->validator = $validator;
    }

    /**
     * @param CommandInterface $command
     * @return bool
     */
    public function execute(CommandInterface $command)
    {
        if (! $command instanceof CreateMemberCommand) {
            throw new \DomainException("Internal error, silahkan hubungi CS kami");
        }

        $command->setRepository($this->member_repo);

        $violation = $this->validator->validate($command);

        if ($violation->count() > 0) {
            $message = $violation->get(0)->getMessage();
            throw new \DomainException($message);
        }

        $member = new Member();
        $member->setAccountId($command->getAccountId());
        $member->setEmail($command->getEmail());
        $member->setAccountNumber($command->getAccountNumber());
        $member->setAccountHolder($command->getAccountHolder());
        $member->setBankName($command->getBankName());
        $member->setFullName($command->getFullname());
        $member->setPhone($command->getPhone());

        $this->member_repo->save($member);

        return true;
    }
}

// EOF
