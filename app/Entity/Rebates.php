<?php
/**
 * Created by PhpStorm.
 * User: awalin
 * Date: 08/01/15
 * Time: 12:06
 */

namespace Mabes\Entity;
/**
 * @Entity
 * @Table(name="rebates")
 **/
class Rebates {
    /**
     * @Id @Column(type="integer"))
     * @var int
     */
    protected $ticket = null;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $login;

    /**
     * @Column(type="datetime")
     * @var datetime
     */
    protected $open_time;

    /**
     * @column(type="integer")
     * @var int
     */

    protected $ticket_referral;

    /**
     *@column(type="float")
     * @var float
     */

    protected $profit;

    /**
     * @return int
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param int $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return datetime
     */
    public function getOpenTime()
    {
        return $this->open_time;
    }

    /**
     * @param datetime $open_time
     */
    public function setOpenTime($open_time)
    {
        $this->open_time = $open_time;
    }

    /**
     * @return float
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @param float $profit
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
    }

    /**
     * @return int
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param int $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return int
     */
    public function getTicketReferral()
    {
        return $this->ticket_referral;
    }

    /**
     * @param int $ticket_referral
     */
    public function setTicketReferral($ticket_referral)
    {
        $this->ticket_referral = $ticket_referral;
    }



} 