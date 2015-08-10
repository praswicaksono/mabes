<?php


namespace Mabes\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mabes\Core\CommonBehaviour\Timestampable;

/**
 * @Entity(repositoryClass="MemberRepository")
 * @Table(name="member", indexes={@Index(name="search_idx", columns={"full_name", "email"})})
 * @HasLifecycleCallbacks
 **/
class Member
{
    use Timestampable;

    /**
     * @Id @Column(type="integer")
     * @var int
     */
    protected $account_id;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $full_name;

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
     * @Column(type="string", length=64)
     * @var string
     */
    protected $bank_name;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $account_number;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    protected $account_holder;

    /**
     * @Column(length=254)
     * @var string
     */
    protected $address;

    /**
     * @OneToOne(targetEntity="ClaimRebate", mappedBy="member")
     * @var ClaimRebate
     */
    protected $claim_rebate;

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
    protected $transfer_from = null;

    /**
     * @OneToMany(targetEntity="Transfer", mappedBy="client_to")
     * @var \Doctrine\Common\Collections\ArrayCollection
     **/
    protected $transfer_to = null;

    /**
     * @OneToMany(targetEntity="InvestorPassword", mappedBy="account_id")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $investor_password = null;

    /**
     *
     */
    public function __construct()
    {
        $this->withdrawals = new ArrayCollection();
        $this->deposits = new ArrayCollection();
        $this->transfer_from = new ArrayCollection();
        $this->transfer_to = new ArrayCollection();
        $this->investor_password = new ArrayCollection();
    }

    /**
     * @param $withdrawal
     */
    public function addWithdrawal($withdrawal)
    {
        $this->withdrawals[] = $withdrawal;
    }

    /**
     * @return ArrayCollection
     */
    public function getWithdrawals()
    {
        return $this->withdrawals;
    }

    /**
     * @param $deposit
     */
    public function addDeposit($deposit)
    {
        $this->deposits[] = $deposit;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeposits()
    {
        return $this->deposits;
    }

    /**
     * @param InvestorPassword $investor_password
     */
    public function addInvestorPassword(InvestorPassword $investor_password)
    {
        $this->investor_password[] = $investor_password;
    }

    /**
     * @return ArrayCollection
     */
    public function getInvestorPasswords()
    {
        return $this->investor_password;
    }

    /**
     * @param $transfer_from
     */
    public function addTransferFrom($transfer_from)
    {
        $this->transfer_from[] = $transfer_from;
    }

    /**
     * @return ArrayCollection
     */
    public function getTransferFrom()
    {
        return $this->transfer_from;
    }

    /**
     * @param $transfer_to
     */
    public function addTransferTo($transfer_to)
    {
        $this->transfer_to[] = $transfer_to;
    }

    /**
     * @return ArrayCollection
     */
    public function getTransferTo()
    {
        return $this->transfer_to;
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
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param string $account_number
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
     * @return ClaimRebate
     */
    public function getClaimRebate()
    {
        return $this->claim_rebate;
    }

    /**
     * @param ClaimRebate $claim_rebate
     */
    public function setClaimRebate(ClaimRebate $claim_rebate)
    {
        $this->claim_rebate = $claim_rebate;
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
