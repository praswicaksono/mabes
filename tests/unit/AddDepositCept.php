<?php
$I = new UnitTester($scenario);
$I->wantTo('add deposit to database');

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

$bank = new \Mabes\Entity\Bank();
$bank->setBankName("BCA");
$bank->setBankAccount("1234567");

$app->em->persist($bank);
$app->em->flush();

$deposit = new \Mabes\Entity\Deposit();
$deposit->setAmountIdr(12500);
$deposit->setAmountUsd(1);
$deposit->setAccountName("Jowy");
$deposit->setPhone("+621234567");
$deposit->setEmail("jowy@oiry.net");
$deposit->setAccountNumber("1234567");
$deposit->setBankFrom("BCA");
$deposit->setStatus(\Mabes\Entity\Deposit::STATUS_OPEN);
$deposit->setBank($bank);
$deposit->setClient($member);
$app->em->persist($deposit);
$app->em->flush();

$I->seeInRepository(
    "Mabes\\Entity\\Deposit",
    [
        "account_name" => "Jowy"
    ]
);

$list_deposit = $app->em->getRepository("Mabes\\Entity\\Deposit")->getDeposit();

$I->assertEquals(count($list_deposit), 1);
