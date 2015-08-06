<?php

namespace Mabes\Service\Command;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\RepositoryAwareTrait;
use Mabes\Core\Contracts\CommandInterface;
use Mabes\Entity\Member;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateMemberCommand
 * @package Mabes\Service\Command
 */
class CreateMemberCommand implements CommandInterface
{
    use RepositoryAwareTrait;
    use MassAssignmentTrait;

    /**
     * @var int
     * @Assert\NotBlank(message="MyHotForex ID tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="MyHotForex ID harus angka")
     */
    protected $account_id;

    /**
     * @var string
     * @Assert\NotBlank(message="Nama lengkap tidak boleh kosong")
     */
    protected $fullname;

    /**
     * @var string
     * @Assert\NotBlank(message="Email tidak boleh kosong")
     * @Assert\Email(message="Format email tidak valid")
     */
    protected $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Nomor handphone tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="Nomor handpone harus angka")
     */
    protected $phone;

    /**
     * @var string
     * @Assert\NotBlank(message="Nama bank tidak boleh kosong")
     */
    protected $bank_name;

    /**
     * @var int
     * @Assert\NotBlank(message="Nomor rekening tidak boleh kosong")
     * @Assert\Regex(pattern="/^\d*(\,|\.)?\d+$/", message="Nomor rekening harus angka")
     */
    protected $account_number;

    /**
     * @var string
     * @Assert\NotBlank(message="Atas nama rekening tidak boleh kosong")
     */
    protected $account_holder;


    /**
     * @var string
     * @Assert\NotBlank(message="Alamat tidak boleh kosong")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Panjang alamat minimal 10 karakter"
     * )
     */
    protected $address;

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
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * @param string $bank_name
     */
    public function setBankName($bank_name)
    {
        $this->bank_name = $bank_name;
    }

    /**
     * @return int
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param int $account_number
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    /**
     * @return string
     */
    public function getAccountHolder()
    {
        return $this->account_holder;
    }

    /**
     * @param string $account_holder
     */
    public function setAccountHolder($account_holder)
    {
        $this->account_holder = $account_holder;
    }

    /**
     * @Assert\False(message="MyHotForex ID sudah terdaftar didalam database, untuk mengubah silahkan hubungi CS")
     */
    public function isMemberExist()
    {
        $member = $this->getRepository()->findOneBy(["account_id" => $this->getAccountId()]);

        return $member instanceof Member ? true : false;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }


}

// EOF
