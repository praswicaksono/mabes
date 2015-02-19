<?php


namespace Mabes\Entity;

/**
 * Class InvestorPassword
 * @package Mabes\Entity
 * @Entity(repositoryClass="InvestorPasswordRepository")
 * @Table(name="investor_password")
 */
class InvestorPassword
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    protected $investor_id;

    /**
     * @ManyToOne(targetEntity="Member", inversedBy="investor_password")
     * @JoinColumn(name="account_id", referencedColumnName="account_id")
     * @var Member
     */
    protected $account_id;

    /**
     * @Column(type="integer")
     * @var string
     */
    protected $mt_account;

    /**
     * @Column(type="string", length=120)
     * @var string
     */
    protected $investor_password;

    /**
     * @return Member
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param Member $member
     */
    public function setAccountId(Member $member)
    {
        $member->addInvestorPassword($this);
        $this->account_id = $member;
    }

    /**
     * @return string
     */
    public function getInvestorPassword()
    {
        return $this->investor_password;
    }

    /**
     * @param string $investor_password
     */
    public function setInvestorPassword($investor_password)
    {
        $this->investor_password = $investor_password;
    }

    /**
     * @return string
     */
    public function getMtAccount()
    {
        return $this->mt_account;
    }

    /**
     * @param string $mt_account
     */
    public function setMtAccount($mt_account)
    {
        $this->mt_account = $mt_account;
    }
}

// EOF
