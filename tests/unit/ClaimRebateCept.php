<?php

$I = new UnitTester($scenario);
$I->wantTo('claim rebate');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "ClaimRebateService",
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

        return new \Mabes\Service\ClaimRebateService($member_repo, $rebate_repo, $validator, $event_emitter);
    }
);

$data = [
    "account_id" => 1234,
    "mt4_account" => 4321,
    "type" => "BANK",
];

$command = new \Mabes\Service\Command\ClaimRebateCommand();
$command->massAssignment($data);

$service = $app->container->get("ClaimRebateService");

$I->assertEquals(true, $service->execute($command));

// EOF
