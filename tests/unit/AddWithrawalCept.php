<?php
$I = new UnitTester($scenario);
$I->wantTo('add withdral to database');

$app = \Slim\Slim::getInstance();

$member = new \Mabes\Entity\Member();
$member->setFullName("Jowy");
$member->setCountry("Indonesia");
$member->setEmail("jowy@oiry.net");
$member->setMemberId(1);
$member->setPhone("+621234567");
$member->setRegisterDate(new DateTime());

$app->em->persist($member);
$app->em->flush();

$withdrawal = new \Mabes\Entity\Withdrawal();
$withdrawal->setEmail("jowy@oiry.net");
$withdrawal->setPhone("+621234567");
$withdrawal->setAccountName("Jowy");
$withdrawal->setBankAccount("123456");
$withdrawal->setAmount(0.89);
$withdrawal->setBankName("BCA");
$withdrawal->setPhonePassword("password");
$withdrawal->setClient($member);
$withdrawal->setCreatedAt(new DateTime());
$withdrawal->setUpdatedAt(new DateTime());
$withdrawal->setStatus(\Mabes\Entity\Withdrawal::STATUS_OPEN);

$app->em->persist($withdrawal);
$app->em->flush();

$I->seeInRepository(
    "Mabes\\Entity\\Withdrawal",
    [
        "account_name" => "Jowy"
    ]
);

$list_withdrawal = $app->em->getRepository("Mabes\\Entity\\Withdrawal")->query(
    "SELECT w FROM Mabes\Entity\Withdrawal w"
);

$I->assertEquals(count($list_withdrawal), 1);
