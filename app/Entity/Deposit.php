<?php


namespace Mabes\Entity;


use Respect\Validation\Validator as v;

/**
 * @Entity
 * @Table(name="deposit", indexes={@Index(name="search_idx", columns={"updated_at", "created_at"})})
 * @HasLifecycleCallbacks
 **/
class Deposit
{
    /**
     * @Id @Column(type="string", length=128) @GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $deposit_id;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $amount_idr;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $amount_usd;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $bank_from;

    /**
     * @Column(type="string", length=32)
     * @var string
     */
    protected $account_number;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $account_name;

    /**
     * @Column(type="string", length=32)
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
     * @var integer
     */
    protected $status;

    /**
     * @Column(type="datetime")
     * @var string
     */
    protected $created_at;

    /**
     * @Column(type="datetime")
     * @var string
     */
    protected $updated_at;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="deposit")
     * @JoinColumn(name="member_id", referencedColumnName="member_id")
     **/
    protected $client;

    /**
     * @ManyToOne(targetEntity="Bank", inversedBy="deposit")
     * @JoinColumn(name="bank_id", referencedColumnName="bank_id")
     **/
    protected $bank;

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function validate()
    {
        v::float()->assert($this->amount_idr);
        v::float()->assert($this->amount_usd);
        v::alnum()->length(2, 32)->assert($this->bank_from);
        v::numeric()->assert($this->account_number);
        v::alnum()->length(2, 64)->assert($this->account_name);
        v::email()->assert($this->email);
        v::numeric("+")->startsWith("+")->assert($this->phone);
        v::notEmpty()->assert($this->status);
    }

    /**
     * @PrePersist
     */
    public function beforeInsert()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * @PreUpdate
     */
    public function beforeUpdate()
    {
        $this->updated_at = new \DateTime();
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
     * @param string $account_number
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->account_number;
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
    public function getAmountIdr()
    {
        return $this->amount_idr;
    }

    /**
     * @param float $amount_usd
     */
    public function setAmountUsd($amount_usd)
    {
        $this->amount_usd = $amount_usd;
    }

    /**
     * @return float
     */
    public function getAmountUsd()
    {
        return $this->amount_usd;
    }

    /**
     * @param mixed $bank
     */
    public function setBank($bank)
    {
        $this->bank = $bank;
    }

    /**
     * @return mixed
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @param string $bank_from
     */
    public function setBankFrom($bank_from)
    {
        $bank_from->addDeposit($this);
        $this->bank_from = $bank_from;
    }

    /**
     * @return string
     */
    public function getBankFrom()
    {
        return $this->bank_from;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $client->addDeposit($this);
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $deposit_id
     */
    public function setDepositId($deposit_id)
    {
        $this->deposit_id = $deposit_id;
    }

    /**
     * @return string
     */
    public function getDepositId()
    {
        return $this->deposit_id;
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


}

// EOF
