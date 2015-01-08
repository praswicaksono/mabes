<?php


namespace Mabes\Controllers;

use Slim\Slim;

abstract class BaseController
{
    protected $app;

    public function __construct()
    {
        $this->app = Slim::getInstance();
    }
}

// EOF
