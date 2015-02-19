<?php


namespace Mabes\Entity;

/**
 * Class ClaimRebate
 * @package Mabes\Entity
 * @Entity(repositoryClass="ClaimRebateRepository")
 * @Table(name="claim_rebate")
 */
class ClaimRebate
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    private $claim_id;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $mt4_account;

    /**
     * @Column(type="string", length=64)
     * @var string
     */
    private $type;

    /**
     * @OneToOne(targetEntity="Member", inversedBy="claim_rebate")
     * @JoinColumn(name="account_id", referencedColumnName="account_id")
     * @var Member
     */
    private $member;

    /**
     * @return int
     */
    public function getClaimId()
    {
        return $this->claim_id;
    }

    /**
     * @param int $claim_id
     */
    public function setClaimId($claim_id)
    {
        $this->claim_id = $claim_id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param Member $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * @return mixed
     */
    public function getMt4Account()
    {
        return $this->mt4_account;
    }

    /**
     * @param mixed $mt4_account
     */
    public function setMt4Account($mt4_account)
    {
        $this->mt4_account = $mt4_account;
    }
}

// EOF
