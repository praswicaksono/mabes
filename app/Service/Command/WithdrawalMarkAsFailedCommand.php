<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Withdrawal;
use Symfony\Component\Validator\Constraints as Assert;

class WithdrawalMarkAsFailedCommand implements CommandInterface
{
    use MassAssignmentTrait;
    use RepositoryAwareTrait;

    /**
     * @Assert\NotBlank(message="Withdrawal id tidak boleh kosong")
     * @var int
     */
    private $withdrawal_id;

    /**
     * @return int
     */
    public function getWithdrawalId()
    {
        return $this->withdrawal_id;
    }

    /**
     * @param int $withdrawal_id
     */
    public function setWithdrawalId($withdrawal_id)
    {
        $this->withdrawal_id = $withdrawal_id;
    }

    /**
     * @Assert\False(message="Withdrawal tidak ada didalam database")
     */
    public function isWithdrawalExist()
    {
        $staff = $this->getRepository()->findOneBy(["withdrawal_id" => $this->getWithdrawalId()]);

        return $staff instanceof Withdrawal ? false : true;
    }
}

// EOF
