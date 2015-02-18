<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

define("APP_DIR", __DIR__ . "/../app/");
define("PUBLIC_DIR", __DIR__);

$config = require __DIR__ . "/../app/Config/Config.php";

define("PUBLIC_DIR_UPLOAD", __DIR__ . "/" . $config["path_upload"]);

$app = new \Slim\Slim([
    "mode" => $config["environment"],
    "templates.path" => __DIR__ . "/../app/Templates",
    "log.enabled" => true,
    "cookies.encrypt" => true,
    "cookies.domain" => $config["session"]["domain"],
    "cookies.path" => $config["session"]["domain"],
    "cookies.lifetime" => "20 minutes",
    "cookies.secure" => $config["session"]["secure"],
    "cookies.httponly" => $config["session"]["httponly"],
    'cookies.secret_key' => $config["secret_key"],
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
]);

// load general config
$app->container->singleton(
    "config",
    function () use ($config) {
        return $config;
    }
);


// view configuration
$app->view(new \Slim\Views\Twig());

$app->view->parserOptions = [
    "debug" => ($config["environment"] == "development") ? true : false,
    "charset" => "utf-8",
    "cache" => __DIR__ . "/../app/Templates/Cache",
    "auto_reload" => ($config["environment"] == "development") ? true : false,
    "strict_variables" => false,
    "autoescape" => true
];

$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// load database module
$app->container->singleton(
    "em",
    function () use ($config) {
        $entity_path = [__DIR__ . "/../app/Entity"];

        // the connection configuration
        $db_conn = Setup::createAnnotationMetadataConfiguration($entity_path, ($config["environment"]) ? true : false);
        return EntityManager::create($config["database"], $db_conn);
    }
);

$app->container->singleton(
    "Validator",
    function () {
        return \Symfony\Component\Validator\Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }
);

// CreateMemberService
$app->container->singleton(
    "CreateMemberService",
    function () use ($app) {
        $member_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Member");
        $validator = $app->container->get("Validator");
        $event_emitter = $app->container->get("EventEmitter");

        return new Mabes\Service\CreateMemberService($member_repo, $validator, $event_emitter);
    }
);

// CreateDepositService
$app->container->singleton(
    "CreateDepositService",
    function () use ($app) {
        $member_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Member");
        $depo_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Deposit");
        $validator = $app->container->get("Validator");
        $event_emitter = $app->container->get("EventEmitter");

        return new \Mabes\Service\CreateDepositService($member_repo, $depo_repo, $validator, $event_emitter);
    }
);

// CreateWithdrawalService
$app->container->singleton(
    "CreateWithdrawalService",
    function () use ($app) {
        $member_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Member");
        $withdrawal_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Withdrawal");
        $validator = $app->container->get("Validator");
        $event_emitter = $app->container->get("EventEmitter");

        return new \Mabes\Service\CreateWithdrawalService($member_repo, $withdrawal_repo, $validator, $event_emitter);
    }
);

// ClaimRebateService
$app->container->singleton(
    "ClaimRebateService",
    function () use ($app) {
        $member_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Member");
        $claim_rebate_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\ClaimRebate");
        $validator = $app->container->get("Validator");
        $event_emitter = $app->container->get("EventEmitter");

        return new \Mabes\Service\ClaimRebateService($member_repo, $claim_rebate_repo, $validator, $event_emitter);
    }
);

// CreateIslamicAccountService
$app->container->singleton(
    "CreateIslamicAccountService",
    function () use ($app) {
        $member_repo = $app->container->get("em")->getRepository("Mabes\\Entity\\Member");
        $validator = $app->container->get("Validator");
        $event_emitter = $app->container->get("EventEmitter");

        return new \Mabes\Service\CreateIslamicAccountService($member_repo, $validator, $event_emitter);
    }
);

// MailerService
$app->container->singleton(
    "MailerService",
    function () use ($app, $config) {
        $templating_service = new \Mabes\Service\EmailTemplatingService();
        return new \Mabes\Service\MailerService(
            $config["email"]["smtp.host"],
            $config["email"]["smtp.port"],
            $config["email"]["smtp.username"],
            $config["email"]["smtp.password"],
            $templating_service
        );
    }
);

// EventEmitter
$app->container->singleton(
    "EventEmitter",
    function () {
        return new \Evenement\EventEmitter();
    }
);


// session manager
$app->container->singleton(
    "session",
    function () {
        return new \RKA\Session();
    }
);

// captcha
$app->container->singleton(
    "captcha",
    function () {
        return new \Gregwar\Captcha\CaptchaBuilder();
    }
);

// initialize custom middleware
$app->add(new \Mabes\Core\CsrfGuardMiddleware());
$app->add(new \RKA\SessionMiddleware($app->config["session"]));
$app->add(new \Mabes\Core\SecurityMiddleware());

// development environment
if ($config["environment"] == "development") {
    $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());
    $app->add(new \Slim\Middleware\DebugBar());
}

// add global variable on twig
$twig = $app->view()->getEnvironment();
$twig->addGlobal('base_url', $config["base_url"]);

// Validator autoload
\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    "Symfony\\Component\\Validator\\Constraint",
    __DIR__ . "/../vendor/symfony/validator"
);

// Event register

// EOF
$emitter = $app->container->get("EventEmitter");

$emitter->on(
    "deposit.created",
    function ($data) use ($app) {
        $mailer = $app->container->get("MailerService");
        $mailer->createMessage("Notifikasi Deposit MabesFx")
            ->send(
                "deposit",
                [
                    "support@mabesfx.com" => "MabesFx Support"
                ],
                [
                    $data["email"], "finance@mabesfx.com"
                ],
                $data
            );
    }
);

$emitter->on(
    "withdrawal.created",
    function ($data) use ($app) {
        $mailer = $app->container->get("MailerService");
        $mailer->createMessage("Notifikasi Withdrawal MabesFx")
            ->send(
                "withdrawal",
                [
                    "support@mabesfx.com" => "MabesFx Support"
                ],
                [
                    $data["email"], "finance@mabesfx.com"
                ],
                $data
            );
    }
);

$emitter->on(
    "validation.created",
    function ($data) use ($app) {
        $mailer = $app->container->get("MailerService");
        $mailer->createMessage("Notifikasi Validasi MabesFx")
            ->send(
                "validation",
                [
                    "support@mabesfx.com" => "MabesFx Support"
                ],
                [
                    $data["email"], "support@mabesfx.com"
                ],
                $data
            );
    }
);

$emitter->on(
    "claim.rebate.created",
    function ($data) use ($app) {
        $mailer = $app->container->get("MailerService");
        $mailer->createMessage("Notifikasi Klaim Rebate MabesFx")
            ->send(
                "klaim_rebate",
                [
                    "support@mabesfx.com" => "MabesFx Support"
                ],
                [
                    $data["email"], "finance@mabesfx.com"
                ],
                $data
            );
    }
);

$emitter->on(
    "akun.islami.created",
    function ($data) use ($app) {
        $mailer = $app->container->get("MailerService");
        $mailer->createMessage("Notifikasi Akun Islami MabesFx")
            ->send(
                "klaim_rebate",
                [
                    "support@mabesfx.com" => "MabesFx Support"
                ],
                [
                    $data["email"], "support@mabesfx.com"
                ],
                $data
            );
    }
);
