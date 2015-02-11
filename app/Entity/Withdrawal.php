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

    /**
<<<<<<< HEAD
     * @Id @Column(type="integer") @GeneratedValue
=======
     * @Id @Column(type="integer") @GeneratedValue(strategy="AUTO")
>>>>>>> 6f5f46f6a2760d4d838b0b98c0b29b8b8df0c484
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
<<<<<<< HEAD
     * @return float
=======
     * @param int $withdrawal_id
>>>>>>> 6f5f46f6a2760d4d838b0b98c0b29b8b8df0c484
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
<<<<<<< HEAD
     * @param float $amount
=======
     * @return int
>>>>>>> 6f5f46f6a2760d4d838b0b98c0b29b8b8df0c484
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}

// EOF
