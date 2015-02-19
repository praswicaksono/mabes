<?php

$I = new UnitTester($scenario);
$I->wantTo('add investor password');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "AddInvestorPasswordService",
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

        $investor_pass_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\InvestorPasswordRepository",
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

        return new \Mabes\Service\AddInvestorPasswordService($member_repo, $investor_pass_repo, $validator, $event_emitter);
    }
);

$data = [
    "account_id" => 1234,
    "mt4_account" => 4321,
    "investor_password" => "AbcgTdy"
];

$command = new \Mabes\Service\Command\AddInvestorPasswordCommand();
$command->massAssignment($data);

$service = $app->container->get("AddInvestorPasswordService");

$I->assertEquals(true, $service->execute($command));

// EOF

