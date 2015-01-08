<?php
use Slim\Slim;

require "vendor/autoload.php";
require "public/bootstrap.php";

$app = Slim::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app->em);

// EOF
