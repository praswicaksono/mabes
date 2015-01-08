<?php
$I = new UnitTester($scenario);
$I->wantTo('add bank to database');

$I->haveInRepository(
    "Mabes\\Entity\\Bank",
    [
        "bank_name" => "BCA",
        "bank_account" => "012345678",
    ]
);

$I->seeInRepository(
    "Mabes\\Entity\\Bank",
    [
        "bank_name" => "BCA"
    ]
);
