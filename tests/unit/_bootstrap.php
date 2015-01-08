<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../public/bootstrap.php";

$app = \Slim\Slim::getInstance();

\Codeception\Module\Doctrine2::$em = $app->em;
// Here you can initialize variables that will be available to your tests
