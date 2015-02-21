<?php

$I = new UnitTester($scenario);
$I->wantTo('add staff');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "CreateStaffService",
    function () use ($app) {
        $staff_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\StaffRepository",
            [
                "findOneBy" => function () {
                    return false;
                },
                "save" => function () {
                    return true;
                }
            ]
        );

        $hash_service = \Codeception\Util\Stub::make(
            "Mabes\\Service\\HashService"
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

        return new \Mabes\Service\CreateStaffService($staff_repo, $hash_service, $validator, $event_emitter);
    }
);

$data = [
    "username" => "john",
    "password" => "123",
];

$command = new \Mabes\Service\Command\CreateStaffCommand();
$command->massAssignment($data);

$service = $app->container->get("CreateStaffService");

$I->assertTrue($service->execute($command));

// EOF
