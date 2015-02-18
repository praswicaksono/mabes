<?php


namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateIslamicAccountCommand implements CommandInterface
{
    use RepositoryAwareTrait;
    use MassAssignmentTrait;

    /**
     * @var int
     * @Assert\NotBlank(message="MyHotForex ID tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="MyHotForex ID harus angka")
     */
    private $account_id;

    /**
     * @var int
     * @Assert\NotBlank(message="Akun MT4 tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="Akun MT4 harus angka")
     */
    private $mt4_account;

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

}

// EOF
