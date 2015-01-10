<?php


namespace Mabes\Controllers;


class AdminController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_admin.twig');
    }
    public function login()
    {
        $this->app->render('Pages/_login.twig');
    }
}

// EOF
