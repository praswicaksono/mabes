<?php
/**
 * Created by PhpStorm.
 * User: awalin
 * Date: 16/01/15
 * Time: 14:37
 */

namespace Mabes\Config;

class DummyData
{
    public $dummy_data;

    /**
     * @var array
     */
    public $member;

    /**
     * @var array
     */
    public $staff;

    /**
     * @var array
     */
    public $bank;

    /**
     * @var array
     */
    public $deposit;

    /**
     * @var array
     */
    public $withdrawal;

    /**
     * @var array
     */
    public $transfer;

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function getBank()
    {
        return [
            [
                'bank_id' => 1,
                'bank_name' => "BCA",
                'bank_account' => "3312133200"
            ],
            [
                'bank_id' => 2,
                'bank_name' => "MANDIRI",
                'bank_account' => "1440011537633"
            ],
            [
                'bank_id' => 3,
                'bank_name' => "BNI",
                'bank_account' => "0280067225"
            ]

        ];
    }

    /**
     * @return array
     */
    public function getDeposit()
    {

        $deposit_class = new \Mabes\Entity\Deposit();

        return [
            [
                'deposit_id' => "284111",
                'amount_idr' => 120.000,
                'amount_usd' => 10.8,
                'bank_from' => 'BCA',
                "account_number" => "29281999",
                'account_name' => "Mustar",
                "email" => "mustar@tar.com",
                "phone" => "+6281336661922",
                "upload_file" => "dummy.jpg",
                "status" => $deposit_class::STATUS_OPEN
            ]
        ];
    }

    /**
     * @return array
     */
    public function getDummyData()
    {
        return [
            'member' => $this->getMember(),
            'staff' => $this->getStaff(),
            'bank' => $this->getBank(),
            'deposit' => $this->getDeposit(),
            'withdrawal' => $this->getWithdrawal(),
            'transfer' => $this->getTransfer(),
        ];
    }

    /**
     * @return array
     */
    public function getMember()
    {
        return [
            [
                "member_id" => 1020182,
                "full_name" => "Prastyo Wicaksono",
                "country" => "Indonesia",
                "phone" => "+621234567",
                "email" => "john@doe.com",
                "register_date" => new \DateTime()
            ],
            [
                "member_id" => 1020183,
                "full_name" => "Awalin Yudhana",
                "country" => "Indonesia",
                "phone" => "+62987654",
                "email" => "jack@kiss.com",
                "register_date" => new \DateTime()
            ]
        ];
    }

    /**
     * @return array
     */
    public function getStaff()
    {
        return [
            [
                'staff_id' => 1,
                'username' => "administrator",
                'password' => "Blink182"
            ],
            [
                'staff_id' => 3,
                'username' => "customer1",
                'password' => "Blink182"
            ],
            [
                'staff_id' => 3,
                'username' => "customer2",
                'password' => "Blink182"
            ]
        ];
    }

    /**
     * @return array
     */
    public function getTransfer()
    {
        $transfer_class = new \Mabes\Entity\Transfer();
        return [
            [
                'transfer_id' => 1,
                'from_name' => "John Kiss",
                'email' => "john@kiss.me",
                'to_name' => "John Doe",
                'amount' => 5.07,
                'phone' => "+6281336661922",
                'status' => $transfer_class::STATUS_OPEN
            ]
        ];
    }

    /**
     * @return array
     */
    public function getWithdrawal()
    {
        $withdrawal_class = new \Mabes\Entity\Withdrawal();

        return [
            [
                'withdrawal_id'=>1,
                'amount' => 10.8,
                'phone_password' => 'Blink182',
                'bank_name' => "BCA",
                "bank_account" => "29281999",
                'account_name' => "Mustar",
                "email" => "john@doe.com",
                "phone" => "+6281336661922",
                "status" => $withdrawal_class::STATUS_OPEN
            ]
        ];
    }
}
