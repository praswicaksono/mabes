<?php
$I = new UnitTester($scenario);
$I->wantTo('edit existing bank');

$I->haveInRepository(
    "Mabes\\Entity\\Staff",
    [
        "username" => "jowy",
        "password" => password_hash("password", PASSWORD_BCRYPT, ["cost" => 10])
    ]
);

$I->execute(
    function () use ($I) {
        $app = \Slim\Slim::getInstance();
        $em = $app->em;

        $staff = $em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "jowy"]);
        $staff->setPassword("password2");
        $staff->setUsername("atreides");

        $em->flush();

        $I->assertTrue($staff->verifyPassword("password2"));
    }
);

$I->seeInRepository(
    "Mabes\\Entity\\Staff",
    [
        "username" => "atreides"
    ]
);
