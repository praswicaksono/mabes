<?php

namespace Mabes\Controllers;

class AuthController extends BaseController
{

    protected function setLoginToken()
    {
        $this->app->session->token = true;
        $this->app->session->user_agent = $_SERVER["HTTP_USER_AGENT"];
        $this->app->session->user_ip = $_SERVER["REMOTE_ADDR"];
    }

    protected function destroyLoginToken()
    {
        $this->app->session->token = null;
        $this->app->session->user_agent = null;
        $this->app->session->user_ip = null;
    }

    public function postLogin()
    {
        $username = $this->app->request->params("username");
        $password = $this->app->request->params("password");

        $staff = $this->app->em->getRepository("Mabes\\Entity\\Staff")->findOneBy(["username" => "$username"]);
        if ($staff != null) {
            if ($staff->verifyPassword($password)) {
                $this->setLoginToken();
                $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
            }
        }

        $data['isError'] = true;
        $data['errorTitle'] = "Login Message";
        $data['errorMessage'] = "invalid username or password";

        $this->app->render('Pages/_login.twig', $data);
    }

    public function getLogin()
    {
        if (isset($this->app->session->token)) {
            $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
        }

        $this->app->render('Pages/_login.twig');
    }

    public function getLogout()
    {
        $this->destroyLoginToken();
        $this->app->response->redirect("{$this->app->config["base_url"]}administrator/login");
    }
}

//EOF
