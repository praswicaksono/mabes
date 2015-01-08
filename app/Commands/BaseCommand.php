<?php


namespace Mabes\Commands;

use Symfony\Component\Console\Command\Command;
use Slim\Slim;

class BaseCommand extends Command
{
    protected $slim_app = null;

    public function __construct()
    {
        $this->slim_app =  Slim::getInstance();
        parent::__construct();
    }
}

// EOF
