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
     * @return array
     */
    public function getDummyData()
    {
        return [
            'Mabes\\Entity\\Member' => $this->getMember(),
            'Mabes\\Entity\\Staff' => $this->getStaff(),
            'Mabes\\Entity\\Bank' => $this->getBank()
        ];
    }

    /**
     * @return array
     */
    public function getBank()
    {
        return [
            [
                'bank_name' => "BCA",
                'bank_account' => "3312133200"
            ],
            [
                'bank_name' => "MANDIRI",
                'bank_account' => "1440011537633"
            ],
            [
                'bank_name' => "BNI",
                'bank_account' => "0280067225"
            ]

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
                'username' => "administrator",
                'password' => password_hash("Blink182", PASSWORD_BCRYPT, ["cost" => 10])
            ],
            [
                'username' => "customer1",
                'password' => password_hash("Blink182", PASSWORD_BCRYPT, ["cost" => 10])
            ],
            [
                'username' => "customer2",
                'password' => password_hash("Blink182", PASSWORD_BCRYPT, ["cost" => 10])
            ]
        ];
    }
}
