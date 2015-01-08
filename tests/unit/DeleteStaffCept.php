<?php 
$I = new UnitTester($scenario);
$I->wantTo('delete staff from database');

$I->haveInRepository(
    "Mabes\\Entity\\Staff",
    [
        "username" => "jowy",
        "password" => password_hash("password", PASSWORD_BCRYPT, ["cost" => 10])
    ]
);

$I->execute(
    function () {
        $app = \Slim\Slim::getInstance();
        $em = $app->em;

        $staff = $em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "jowy"]);
        $em->remove($staff);
        $em->flush();
    }
);

$I->dontSeeInRepository("Mabes\\Entity\\Staff", ["username" => "jowy"]);
