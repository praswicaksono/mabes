<?php

namespace Mabes\Controllers;

use Mabes\Service\Command\AuthCommand;

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

    public function getLogin()
    {
        if (! is_null($this->app->session->token)) {
            $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
        }

        $this->app->render('Pages/_login.twig');
    }

    public function postLogin()
    {
       try {
           $auth_service = $this->app->container->get("AuthService");

           $auth_command = new AuthCommand();
           $auth_command->massAssignment($this->app->request->post());

           $auth_service->execute($auth_command);

           $this->setLoginToken();

           $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
       } catch (\DomainException $e) {
           $this->validationMessage(
               [
                   "custom" => $e->getMessage()
               ]
           );
       }

        $this->app->render('Pages/_login.twig');
    }

    public function getLogout()
    {
        $this->destroyLoginToken();
        $this->app->response->redirect("{$this->app->config["base_url"]}auth/login");
    }
}

//EOF
