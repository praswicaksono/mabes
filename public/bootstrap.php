<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

define("APP_DIR", __DIR__ . "/../app/");
define("PUBLIC_DIR", __DIR__);

$config = require __DIR__ . "/../app/Config/Config.php";

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


// session manager
$app->container->singleton(
    "session",
    function () {
        return new \RKA\Session();
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


// EOF
