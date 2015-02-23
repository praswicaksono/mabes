<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Deposit;
use Symfony\Component\Validator\Constraints as Assert;

class DepositMarkAsDoneCommand implements CommandInterface
{
    use MassAssignmentTrait;
    use RepositoryAwareTrait;

    /**
     * @Assert\NotBlank(message="Deposit id tidak boleh kosong")
     * @var int
     */
    private $deposit_id;

    /**
     * @return int
     */
    public function getDepositId()
    {
        return $this->deposit_id;
    }

    /**
     * @param int $deposit_id
     */
    public function setDepositId($deposit_id)
    {
        $this->deposit_id = $deposit_id;
    }

    /**
     * @Assert\False(message="Deposit tidak ada didalam database")
     */
    public function isStaffExist()
    {
        $staff = $this->getRepository()->findOneBy(["deposit_id" => $this->getDepositId()]);

        return $staff instanceof Deposit ? false : true;
    }
}

// EOF
