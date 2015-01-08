<?php 
$I = new UnitTester($scenario);
$I->wantTo("delete existing member from database");

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
        $em->remove($member);
        $em->flush();
    }
);

$I->dontSeeInRepository("Mabes\\Entity\\Member", ["full_name" => "Jowy"]);
