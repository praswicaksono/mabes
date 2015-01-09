<?php


namespace Mabes\Controllers;


class HelloController extends BaseController
{
    public function index()
    {
        $this->app->log->info("requesting /hello/:name");

        $this->app->render("index.html");
    }
}

// EOF
 