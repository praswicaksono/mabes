<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Member;
use Symfony\Component\Validator\Constraints as Assert;

class CreateDepositCommand implements CommandInterface
{
    use MassAssignmentTrait;
    use RepositoryAwareTrait;

    /**
     * @var int
     * @Assert\NotBlank(message="MyHotForex ID tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="MyHotForex ID harus angka")
     */
    private $account_id;

    /**
     * @var float
     * @Assert\NotBlank(message="Jumlah IDR tidak boleh kosong")
     * @Assert\Regex(pattern="/^[0-9]+([.|,][0-9]+)?$/", message="Jumlah IDR harus desimal")
     */
    private $amount_idr;

    /**
     * @var float
     * @Assert\NotBlank(message="Jumlah USD tidak boleh kosong")
     * @Assert\Regex(pattern="/^[0-9]+([.|,][0-9]+)?$/", message="Jumlah USD harus desimal")
     */
    private $amount_usd;

    /**
     * @var string
     * @Assert\NotBlank(message="Transber ke bank tidak boleh kosong")
     */
    private $to_bank;

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
    public function getAmountIdr()
    {
        return $this->amount_idr;
    }

    /**
     * @param float $amount_idr
     */
    public function setAmountIdr($amount_idr)
    {
        $this->amount_idr = $amount_idr;
    }

    /**
     * @return float
     */
    public function getAmountUsd()
    {
        return $this->amount_usd;
    }

    /**
     * @param float $amount_usd
     */
    public function setAmountUsd($amount_usd)
    {
        $this->amount_usd = $amount_usd;
    }

    /**
     * @return string
     */
    public function getToBank()
    {
        return $this->to_bank;
    }

    /**
     * @param string $to_bank
     */
    public function setToBank($to_bank)
    {
        $this->to_bank = $to_bank;
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
