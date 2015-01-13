<?php


namespace Mabes\Controllers;

use Slim\Slim;

abstract class BaseController
{
    protected $app;

    protected $captcha_builder;

    public function __construct()
    {
        $this->app = Slim::getInstance();
    }

    protected function buildCaptcha()
    {
        $this->captcha_builder = $this->app->captcha;
        $this->captcha_builder->setIgnoreAllEffects(true);
        $this->captcha_builder->build("128", "80");

        $this->app->session->phrase = $this->captcha_builder->getPhrase();

        return $this->captcha_builder;
    }

    protected function populateForm($post_data)
    {
        foreach ($post_data as $key => $value) {
            $this->app->view()->appendData(
                [
                    $key => $value
                ]
            );
        }
    }

    protected function validationMessage($errors)
    {
        foreach ($errors as $key => $value) {
            if (!empty($value)) {
                $this->app->view()->appendData([
                        "isError" => true,
                        "errorTitle" => "Error",
                        "errorMessage" => $value
                    ]);
            }
            $this->populateForm($this->app->request->post());
        }
    }
}

// EOF
