<?php

require __DIR__ . "/../vendor/autoload.php";

require "bootstrap.php";

$mabes = new \Mabes\Core\Application($app);
$mabes->mountControllers();
$mabes->run();

// EOF
