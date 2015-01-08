<?php
$I = new UnitTester($scenario);
$I->wantTo('add staff to database');

$I->haveInRepository(
    "Mabes\\Entity\\Staff",
    [
        "username" => "jowy",
        "password" => password_hash("password", PASSWORD_BCRYPT, ["cost" => 10])
    ]
);

$I->seeInRepository(
    "Mabes\\Entity\\Staff",
    [
        "username" => "jowy"
    ]
);

$app = \Slim\Slim::getInstance();
$em = $app->em;

$staff = $em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "jowy"]);

$I->assertTrue($staff->verifyPassword("password"));
