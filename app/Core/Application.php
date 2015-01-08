<?php


namespace Mabes\Core;


use Slim\Slim;

class Application
{
    protected $app;

    public function __construct(Slim $app)
    {
        $this->app = $app;
    }

    public function run()
    {
        $this->app->run();
    }

    public function mountControllers()
    {
        require APP_DIR . "Config/Routing.php";

        foreach ($routing as $route) {
            $this->app->$route["http_method"]($route["route"], $route["class"] . ":" . $route["method"]);
        }
    }
}

// EOF
