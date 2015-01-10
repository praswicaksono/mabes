<?php


namespace Mabes\Controllers;


class RebatesController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_rebates.twig');
    }
}

// EOF
