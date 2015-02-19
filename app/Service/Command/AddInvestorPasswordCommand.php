<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class AddInvestorPasswordCommand implements CommandInterface
{
    use RepositoryAwareTrait;
    use MassAssignmentTrait;

    /**
     * @Assert\NotBlank(message="MyHotForex ID tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="MyHotForex ID harus angka")
     * @var int
     */
    private $account_id;

    /**
     * @Assert\NotBlank(message="No akun trading tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="No akun trading harus angka")
     * @var int
     */
    private $mt4_account;

    /**
     * @Assert\NotBlank(message="investor tidak boleh kosong")
     * @var string
     */
    private $investor_password;

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
     * @return int
     */
    public function getMt4Account()
    {
        return $this->mt4_account;
    }

    /**
     * @param int $mt4_account
     */
    public function setMt4Account($mt4_account)
    {
        $this->mt4_account = $mt4_account;
    }

    /**
     * @return string
     */
    public function getInvestorPassword()
    {
        return $this->investor_password;
    }

    /**
     * @param string $investor_password
     */
    public function setInvestorPassword($investor_password)
    {
        $this->investor_password = $investor_password;
    }
}

// EOF
