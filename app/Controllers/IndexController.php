<?php


namespace Mabes\Controllers;


class IndexController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_index.twig');
    }
}

// EOF
