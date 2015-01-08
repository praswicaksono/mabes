<?php
$I = new UnitTester($scenario);
$I->wantTo("delete existing bank from database");

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
        $em->remove($bank);
        $em->flush();
    }
);

$I->dontSeeInRepository("Mabes\\Entity\\Bank", ["bank_name" => "BCA"]);
