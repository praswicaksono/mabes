<?php


namespace Mabes\Entity;

use Respect\Validation\Validator as v;

/**
 * @Entity(repositoryClass="WithdrawalRepository")
 * @Table(name="withdrawal", indexes={@Index(name="search_idx", columns={"updated_at", "created_at"})})
 * @HasLifecycleCallbacks
 **/
class Withdrawal
{
    use MassAssignmentTrait;

    const STATUS_OPEN = 1;

    const STATUS_PROCESSED = 2;

    /**
     * @Id @Column(type="string", length=128) @GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $withdrawal_id;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="withdrawal")
     * @JoinColumn(name="member_id", referencedColumnName="member_id")
     * @var \Mabes\Entity\Member
     **/
    protected $client;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $amount;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $phone_password;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $bank_name;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $bank_account;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $account_name;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $phone;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $status;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @Column(type="datetime")
     * @var \DateTime
     */
    protected $updated_at;

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function validate()
    {
        v::alnum()->notEmpty()->assert($this->bank_name);

        v::alnum()->notEmpty()->assert($this->account_name);

        v::email()->notEmpty()->equals($this->client->getEmail())->assert($this->email);

        v::alnum()->notEmpty()->assert($this->phone_password);

        v::numeric("+")->notEmpty()->startsWith("+")->assert($this->phone);

        v::float()->notEmpty()->assert($this->amount);

        v::numeric()->notEmpty()->assert($this->bank_account);

        v::notEmpty()->notEmpty()->assert($this->client);


        v::numeric()->notEmpty()->assert($this->status);
    }

    /**
     * @PrePersist
     */
    public function beforeInsert()
    {
        $this->created_at =  new \DateTime();
        $this->updated_at =  new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function beforeUpdate()
    {
        $this->updated_at =  new \DateTime();
    }

    /**
     * @param string $account_name
     */
    public function setAccountName($account_name)
    {
        $this->account_name = $account_name;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->account_name;
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
    public function getBankName()
    {
        return $this->bank_name;
    }

    /**
     * @param string $bank_account
     */
    public function setBankAccount($bank_account)
    {
        $this->bank_account = $bank_account;
    }

    /**
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bank_account;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \Mabes\Entity\Member $client
     */
    public function setClient($client)
    {
        $client->addWithdrawal($this);
        $this->client = $client;
    }

    /**
     * @return \Mabes\Entity\Member
     */
    public function getClient()
    {
        return $this->client;
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
    public function getEmail()
    {
        return $this->email;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone_password
     */
    public function setPhonePassword($phone_password)
    {
        $this->phone_password = $phone_password;
    }

    /**
     * @return string
     */
    public function getPhonePassword()
    {
        return $this->phone_password;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param string $withdrawal_id
     */
    public function setWithdrawalId($withdrawal_id)
    {
        $this->withdrawal_id = $withdrawal_id;
    }

    /**
     * @return string
     */
    public function getWithdrawalId()
    {
        return $this->withdrawal_id;
    }
}

// EOF
