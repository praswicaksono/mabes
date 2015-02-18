<?php

$I = new UnitTester($scenario);
$I->wantTo('create islamic account');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "CreateIslamicAccountService",
    function () use ($app) {
        $member_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\MemberRepository",
            [
                "findOneBy" => function () {
                    $member = new \Mabes\Entity\Member();
                    $member->setAccountId(12345);
                    $member->setCreatedAt(new \DateTime());
                    return $member;
                }
            ]
        );

        $rebate_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\ClaimRebateRepository",
            [
                "save" => function () {
                    return true;
                }
            ]
        );

        $event_emitter = \Codeception\Util\Stub::make(
            "\\Evenement\\EventEmitter",
            [
                "emit" => function () {
                    return true;
                }
            ]
        );

        $validator = $app->container->get("Validator");

        return new \Mabes\Service\CreateIslamicAccountService($member_repo, $validator, $event_emitter);
    }
);

$data = [
    "account_id" => 1234,
    "mt4_account" => 12345,
];

$command = new \Mabes\Service\Command\CreateIslamicAccountCommand();
$command->massAssignment($data);

$service = $app->container->get("CreateIslamicAccountService");

$I->assertEquals(true, $service->execute($command));