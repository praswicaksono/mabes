<?php

$I = new UnitTester($scenario);
$I->wantTo('edit existing bank');

$I->haveInRepository(
    "Mabes\\Entity\\Bank",
    [
        "bank_name" => "BCA",
        "bank_account" => "01234678"
    ]
);

$I->execute(
    function () {
        $app = \Slim\Slim::getInstance();
        $em = $app->em;

        $bank = $em->getRepository("Mabes\\Entity\\Bank")->findOneBy(["bank_name" => "BCA"]);
        $bank->setBankName("BNI");
        $em->flush();
    }
);

$I->seeInRepository(
    "Mabes\\Entity\\Bank",
    [
        "bank_name" => "BNI"
    ]
);