<?php


namespace Mabes\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Respect\Validation\Validator as v;

/**
 * @Entity
 * @Table(name="member", indexes={@Index(name="search_idx", columns={"full_name", "email"})})
 * @HasLifecycleCallbacks
 **/
class Member
{
    /**
     * @Id @Column(type="integer")
     * @var int
     */
    protected $member_id;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $full_name;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $country;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $phone;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="date")
     * @var string
     */
    protected $register_date;

    /**
     * @OneToMany(targetEntity="Withdrawal", mappedBy="client")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $withdrawals = null;

    /**
     * @OneToMany(targetEntity="Deposit", mappedBy="client")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $deposits = null;

    /**
     * @OneToMany(targetEntity="Transfer", mappedBy="client_from")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $transfers_from = null;

    /**
     * @OneToMany(targetEntity="Transfer", mappedBy="client_to")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $transfers_to = null;

    public function __construct()
    {
        $this->withdrawals = new ArrayCollection();
        $this->deposits = new ArrayCollection();
        $this->transfers_from = new ArrayCollection();
        $this->transfers_to = new ArrayCollection();
    }

    public function addWithdrawal($withdrawal)
    {
        $this->withdrawals[] = $withdrawal;
    }

    public function getWithdrawals()
    {
        return $this->withdrawals;
    }

    public function addDeposit($deposit)
    {
        $this->deposits[] = $deposit;
    }

    public function getDeposits()
    {
        return $this->deposits;
    }

    public function addTransfersFrom($transfer_from)
    {
        $this->transfers_from[] = $transfer_from;
    }

    public function getTransfersFrom()
    {
        return $this->transfers_from;
    }

    public function addTransfersTo($transfer_to)
    {
        $this->transfers_to[] = $transfer_to;
    }

    public function getTransfersTo()
    {
        return $this->transfers_to;
    }


    /**
     * @PrePersist @PreUpdate
     */
    public function validate()
    {
        // member_id validation
        v::numeric()->assert($this->member_id);

        // full_name validation
        v::alnum()->length(3, 128)->assert($this->full_name);

        // country validation
        v::alnum()->assert($this->country);

        // phone validation
        v::numeric("+")->startsWith("+")->assert($this->phone);

        // email validation
        v::email()->assert($this->email);

        // register_date validation
        v::date()->assert($this->register_date);
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param int $member_id
     */
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;
    }

    /**
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $register_date
     */
    public function setRegisterDate($register_date)
    {
        $this->register_date = $register_date;
    }

    /**
     * @return mixed
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }
}

// EOF
