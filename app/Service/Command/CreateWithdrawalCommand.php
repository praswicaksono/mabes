<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Member;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateWithdrawalCommand
 * @package Mabes\Service\Command
 */
class CreateWithdrawalCommand implements CommandInterface
{
    use MassAssignmentTrait;
    use RepositoryAwareTrait;

    /**
     * @var int
     * @Assert\NotBlank(message="MyHotForex ID tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="HotForex ID harus angka")
     */
    private $account_id;

    /**
     * @var float
     * @Assert\NotBlank(message="Jumlah withdrawal tidak boleh kosong")
     * @Assert\Regex(pattern="/^[0-9]+([.|,][0-9]+)?$/", message="Jumlah withdrawal harus desimal")
     */
    private $amount;

    /**
     * @return int
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param int $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @Assert\False(message="MyHotForex ID tidak ditemukan didalam database, silahkan validasi akun anda terlebih dahulu")
     */
    public function isMemberExist()
    {
        $member = $this->getRepository()->findOneBy(["account_id" => $this->getAccountId()]);

        return $member instanceof Member ? false : true;
    }
}

// EOF
