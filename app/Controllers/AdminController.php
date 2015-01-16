<?php


namespace Mabes\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        $this->app->response->redirect($this->app->config["base_url"]."administrator/withdrawal");
    }
}

// EOF
