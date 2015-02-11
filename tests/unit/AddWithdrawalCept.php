<?php

$I = new UnitTester($scenario);
$I->wantTo('add withdrawal');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "CreateWithdrawalService",
    function () use ($app) {
        $member_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\MemberRepository",
            [
                "findOneBy" => function () {
                    $member = new \Mabes\Entity\Member();
                    $member->setAccountId(12345);
                    return $member;
                }
            ]
        );

        $wd_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\WithdrawalRepository",
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

        return new \Mabes\Service\CreateWithdrawalService($member_repo, $wd_repo, $validator, $event_emitter);
    }
);

$data = [
    "account_id" => 1234,
    "amount" => 1,
];

$command = new \Mabes\Service\Command\CreateWithdrawalCommand();
$command->massAssignment($data);

$service = $app->container->get("CreateWithdrawalService");

$I->assertEquals(null, $service->execute($command));

// EOF
