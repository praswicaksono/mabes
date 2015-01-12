<?php


namespace Mabes\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
//        $this->app->render('Pages/_admin.twig');
    }

    public function login()
    {
        if ($this->app->request->isGet()) {
        }
        if ($this->app->request->isPost()) {
            $username = $this->app->request->params('username');
            $password = $this->app->request->params('password');


            $staff = $this->app->em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "$username"]);
            if ($staff != null) {
                if ($staff->verifyPassword($password)) {
                    echo "yes";
                }
            }
            $this->app->flashNow('error', "invalid username and password");
        }
        $this->app->render('Pages/_login.twig');
    }

}

// EOF
