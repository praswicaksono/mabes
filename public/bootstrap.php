<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

define("APP_DIR", __DIR__ . "/../app/");
define("PUBLIC_DIR", __DIR__);

$app = new \Slim\Slim([
    "templates.path" => __DIR__ . "/../app/Templates"
]);

// load log module
$app->container->singleton(
    "log",
    function () {
        $log = new \Monolog\Logger("ib-portal");
        $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . "/../app/Logs/app.log"), \Monolog\Logger::DEBUG);
        return $log;
    }
);

// load general config
$app->container->singleton(
    "config",
    function () {
        require __DIR__ . "/../app/Config/Config.php";
        return $config;
    }
);

// view configuration
$app->view(new \Slim\Views\Twig());

$app->view->parserOptions = [
    'charset' => 'utf-8',
    'cache' => __DIR__ . "/../app/Templates/Cache",
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
];

$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// load database module
$app->container->singleton(
    "em",
    function () use ($app) {
        $entity_path = [__DIR__ . "/../app/Entity"];

        // the connection configuration
        $config = Setup::createAnnotationMetadataConfiguration($entity_path, $app->config["dev"]);
        return EntityManager::create($app->config["database"], $config);
    }
);

// session manager middleware
$app->add(new \RKA\SessionMiddleware($app->config["session"]));

// session manager
$app->container->singleton(
    "session",
    function () {
        return new \RKA\Session();
    }
);

// development environment
if ($app->config["dev"]) {
    $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());
    $app->add(new \Slim\Middleware\DebugBar());
}

// EOF
