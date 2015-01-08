<?php 
$I = new UnitTester($scenario);
$I->wantTo('add rebates to database');

$I->haveInRepository(
    "Mabes\\Entity\\Rebates",
    [
        "ticket" => 182911,
        "login" => "2539122",
        "open_time" => new DateTime(),
        "ticket_referral" => 182913,
        "profit" => 0.08
    ]
);

$I->seeInRepository(
    "Mabes\\Entity\\Rebates",
    [
        "ticket" => "182911"
    ]
);