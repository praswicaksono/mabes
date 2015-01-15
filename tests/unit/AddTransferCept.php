<?php 
$I = new UnitTester($scenario);
$I->wantTo('add transfer to database');

$app = \Slim\Slim::getInstance();

$member_from = new \Mabes\Entity\Member();
$member_from->setMemberId(1);
$member_from->setFullName("Jowy");
$member_from->setCountry("Indonesia");
$member_from->setEmail("jowy@oiry.net");
$member_from->setPhone("+621234567");
$member_from->setRegisterDate(new DateTime());

$app->em->persist($member_from);
$app->em->flush();

$member_to = new \Mabes\Entity\Member();
$member_to->setMemberId(2);
$member_to->setFullName("Awalin");
$member_to->setCountry("Indonesia");
$member_to->setEmail("john@doe.com");
$member_to->setPhone("+621234567");
$member_to->setRegisterDate(new DateTime());

$app->em->persist($member_to);
$app->em->flush();

$transfer = new \Mabes\Entity\Transfer();
$transfer->setAmount(1);
$transfer->setFromLogin($member_from);
$transfer->setToLogin($member_to);
$transfer->setPhone("+6234567");
$transfer->setStatus($transfer::STATUS_OPEN);

$app->em->persist($transfer);
$app->em->flush();

$I->seeInRepository(
    "Mabes\\Entity\\Transfer",
    [
        "phone" => "+6234567"
    ]
);

$list_Transfer = $app->em->getRepository("Mabes\\Entity\\Transfer")->query(
    "SELECT t FROM Mabes\\Entity\\Transfer t"
);

$I->assertEquals(count($list_Transfer), 1);
