<?php


namespace Mabes\Controllers;

use Mabes\Core\SecurityMiddleware;

class AdminController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_admin.twig');
    }

    public function login()
    {
        if ($this->app->session->token === true) {
            $this->app->redirect('/administrator');
        }
        $data = array();
        if ($this->app->request->isPost()) {
            $username = $this->app->request->params('username');
            $password = $this->app->request->params('password');

            $staff = $this->app->em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "$username"]);
            if ($staff != null) {
                print_r($staff);
                if ($staff->verifyPassword($password)) {
                    $this->app->session->token = true;
                    $this->app->redirect('/administrator');
                }
            }
            $data['isError'] = true;
            $data['errorTitle'] = "Login Message";
            $data['errorMessage'] = "invalid username and password";
        }
        $this->app->render('Pages/_login.twig', $data);
    }
}

// EOF
