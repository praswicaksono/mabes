<?php
$I = new UnitTester($scenario);
$I->wantTo('edit existing member');

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

$I->execute(
    function () {
        $app = \Slim\Slim::getInstance();
        $em = $app->em;

        $member = $em->find("Mabes\\Entity\\Member", 1);
        $member->setFullName("Atreides");
        $em->flush();
    }
);

$I->seeInRepository(
    "Mabes\\Entity\\Member",
    [
        "full_name" => "Atreides"
    ]
);
