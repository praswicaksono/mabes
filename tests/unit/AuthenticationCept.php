<?php

$I = new UnitTester($scenario);
$I->wantTo('auth staff');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "AuthService",
    function () use ($app) {
        $hash_service = new \Mabes\Service\HashService("1234");

        $hash = $hash_service->hash();

        $staff_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\StaffRepository",
            [
                "findOneBy" => function () use ($hash) {
                    $staff = new \Mabes\Entity\Staff();
                    $staff->setPassword($hash);
                    return $staff;
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

        $auth_password = \Codeception\Util\Stub::make(
            "Mabes\\Service\\AuthPasswordService"
        );

        $validator = $app->container->get("Validator");

        return new \Mabes\Service\AuthService($staff_repo, $auth_password, $validator, $event_emitter);
    }
);

$data = [
    "username" => "john",
    "password" => "1234"
];

$command = new \Mabes\Service\Command\AuthCommand();
$command->massAssignment($data);

$service = $app->container->get("AuthService");

$I->assertTrue($service->execute($command));

// EOF
