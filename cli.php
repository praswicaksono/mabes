<?php
use Symfony\Component\Console\Application;

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/public/bootstrap.php";

$console = new Application();
$console->add(new \Mabes\Commands\ImportRebateCommand());
$console->add(new \Mabes\Commands\InstallCommand());
$console->run();

// EOF
