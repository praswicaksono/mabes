<?php


namespace Mabes\Entity;

use Mabes\Core\CommonBehaviour\MassAssignmentTrait;
use Mabes\Core\CommonBehaviour\Timestampable;

/**
 * @Entity(repositoryClass="WithdrawalRepository")
 * @Table(name="withdrawal", indexes={@Index(name="search_idx", columns={"updated_at", "created_at"})})
 * @HasLifecycleCallbacks
 **/
class Withdrawal
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
    protected $withdrawal_id;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="withdrawal")
     * @JoinColumn(name="account_id", referencedColumnName="account_id")
     * @var \Mabes\Entity\Member
     **/
    protected $client;

    /**
     * @Column(type="float")
     * @var float
     */
    protected $amount;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $status;

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
     * @param int $withdrawal_id
     */
    public function setWithdrawalId($withdrawal_id)
    {
        $this->withdrawal_id = $withdrawal_id;
    }

    /**
     * @return int
     */
    public function getWithdrawalId()
    {
        return $this->withdrawal_id;
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
}

// EOF
