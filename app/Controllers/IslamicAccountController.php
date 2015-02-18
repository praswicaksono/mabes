<?php


namespace Mabes\Controllers;

use Mabes\Service\Command\CreateIslamicAccountCommand;

class IslamicAccountController extends BaseController
{
    public function getIslamicAccount()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_islamic_account.twig');
    }

    public function postIslamicAccount()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $islamic_account_service = $this->app->container->get("CreateIslamicAccountService");

            $islamic_account_command = new CreateIslamicAccountCommand();
            $islamic_account_command->massAssignment($this->app->request->post());

            $islamic_account_service->execute($islamic_account_command);

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Berhasil",
                    "successMessage" => "Data berhasil kami terima"
                ]
            );

        } catch (\DomainException $e) {
            $this->validationMessage(
                [
                    "custom" => $e->getMessage()
                ]
            );
        }

        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_islamic_account.twig');
    }
}

// EOF
