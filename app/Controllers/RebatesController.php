<?php


namespace Mabes\Controllers;


class RebatesController extends BaseController
{
    public function getRebates()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_rebates.twig');
    }

    public function postRebates()
    {

    }
}

// EOF
