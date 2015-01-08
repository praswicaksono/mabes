<?php
$I = new UnitTester($scenario);
$I->wantTo('add member to database');

$I->haveInRepository(
    "Mabes\\Entity\\Member",
    [
        "member_id" => 1,
        "full_name" => "Jowy",
        "country" => "Indonesia",
        "phone" => "+62089660745453",
        "email" => "jowy@oiry.net",
        "register_date" => new DateTime()
    ]
);

$I->seeInRepository(
    "Mabes\\Entity\\Member",
    [
        "full_name" => "Jowy"
    ]
);
