<?php
use Symfony\Component\Console\Application;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/public/bootstrap.php";

$console = new Application();
$console->add(new \Mabes\Commands\CreateStaffCommand());
$console->run();

// EOF
