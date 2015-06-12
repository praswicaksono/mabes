<?php


namespace Mabes\Entity;


use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\Timestampable;

/**
 * @Entity(repositoryClass="DepositRepository")
 * @Table(name="deposit", indexes={@Index(name="search_idx", columns={"updated_at", "created_at"})})
 * @HasLifecycleCallbacks
 **/
class Deposit
{
    use Timestampable;
    use MassAssignmentTrait;

    const STATUS_OPEN = 1;

    const STATUS_PROCESSED = 2;

    const STATUS_FAILED = 3;

    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $deposit_id;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $amount_idr;

    /**
     * @Column(type="float", nullable=true)
     * @var float
     */
    protected $amount_usd;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    protected $to_bank;

    /**
     * @Column(type="integer")
     * @var integer
     */
    protected $status;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="deposit")
     * @JoinColumn(name="account_id", referencedColumnName="account_id")
     * @var \Mabes\Entity\Member
     **/
    protected $client;


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
     * @param int $deposit_id
     */
    public function setDepositId($deposit_id)
    {
        $this->deposit_id = $deposit_id;
    }

    /**
     * @return int
     */
    public function getDepositId()
    {
        return $this->deposit_id;
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
}

// EOF
