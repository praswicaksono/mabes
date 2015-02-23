<?php

$I = new UnitTester($scenario);
$I->wantTo('mark as done withdrawal ticket');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "WithdrawalMarkAsDoneService",
    function () use ($app) {
        $withdrawal_repository = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\WithdrawalRepository",
            [
                "findOneBy" => function () {
                    $withdrawal = new \Mabes\Entity\Withdrawal();
                    $withdrawal->setStatus(\Mabes\Entity\Withdrawal::STATUS_OPEN);
                    return $withdrawal;
                },
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

        return new \Mabes\Service\WithdrawalMarkAsDoneService($withdrawal_repository, $validator, $event_emitter);
    }
);

$data = [
    "withdrawal_id" => 1,
];

$command = new \Mabes\Service\Command\WithdrawalMarkAsDoneCommand();
$command->massAssignment($data);

$service = $app->container->get("WithdrawalMarkAsDoneService");

$I->assertEquals(true, $service->execute($command));

// EOF

