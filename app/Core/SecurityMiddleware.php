<?php


namespace Mabes\Core;


use Slim\Middleware;

class SecurityMiddleware extends Middleware
{
    public function call()
    {
        $this->app->hook("slim.before.router", [$this, 'check']);
        $this->next->call();
    }

    public function check()
    {
        $request = $this->app->request();
        $uri = explode("?", $request->getResourceUri());

        $routes = require APP_DIR . "Config/Routing.php";

        foreach ($routes as $route) {
            if ($uri[0] == $route["route"] && $route["auth"] == true) {
                if (!$this->checkToken()) {
                    $this->app->response->redirect("{$this->app->config["base_url"]}/auth/login");
                }
            }
        }
    }

    private function checkToken()
    {
        if (is_null($this->app->session->token)) {
            return false;
        }

        return true;
    }
}

// EOF
