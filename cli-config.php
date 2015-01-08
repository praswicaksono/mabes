<?php
use Slim\Slim;

require "public/bootstrap.php";

$app = Slim::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($app->em);

// EOF
