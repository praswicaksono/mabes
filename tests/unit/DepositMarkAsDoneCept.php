<?php

$I = new UnitTester($scenario);
$I->wantTo('mark as done deposit ticket');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "DepositMarkAsDoneService",
    function () use ($app) {
        $deposit_repository = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\DepositRepository",
            [
                "findOneBy" => function () {
                    $deposit = new \Mabes\Entity\Deposit();
                    $deposit->setStatus(\Mabes\Entity\Deposit::STATUS_OPEN);
                    return $deposit;
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

        return new \Mabes\Service\DepositMarkAsDoneService($deposit_repository, $validator, $event_emitter);
    }
);

$data = [
    "deposit_id" => 1,
];

$command = new \Mabes\Service\Command\DepositMarkAsDoneCommand();
$command->massAssignment($data);

$service = $app->container->get("DepositMarkAsDoneService");

$I->assertEquals(true, $service->execute($command));

// EOF

