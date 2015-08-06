<?php
$I = new UnitTester($scenario);
$I->wantTo('add member');

$app = \Slim\Slim::getInstance();

$app->container->singleton(
    "CreateNewMemberService",
    function () use ($app) {
        $member_repo = \Codeception\Util\Stub::make(
            "\\Mabes\\Entity\\MemberRepository",
            [
                "save" => function () {
                    return true;
                }
            ]
        );
        $validator = $app->container->get("Validator");

        $event_emitter = \Codeception\Util\Stub::make(
            "\\Evenement\\EventEmitter",
            [
                "emit" => function () {
                    return true;
                }
            ]
        );

        return new Mabes\Service\CreateMemberService($member_repo, $validator, $event_emitter);
    }
);


// test
$data = [
    "account_id" => "123",
    "email" => "john@doe.net",
    "phone" => "123456789",
    "fullname"=> "John Doe",
    "bank_name" => "BCA",
    "account_number" => "123456789",
    "account_holder" => "John Doe",
    "address" => "55335 Corwin Rd # A970289, Elkhart, Indiana 46514, USA"
];

$command = new \Mabes\Service\Command\CreateMemberCommand();
$command->massAssignment($data);

$create_member_service = $app->container->get("CreateNewMemberService");

$I->assertTrue($create_member_service->execute($command));