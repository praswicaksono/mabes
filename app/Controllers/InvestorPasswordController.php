<?php


namespace Mabes\Controllers;

use Mabes\Service\Command\AddInvestorPasswordCommand;

class InvestorPasswordController extends BaseController
{
    public function getInvestorPassword()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_investor_password.twig');
    }

    public function postInvestorPassword()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $investor_password_service = $this->app->container->get("AddInvestorPasswordService");

            $investor_password_command = new AddInvestorPasswordCommand();
            $investor_password_command->massAssignment($this->app->request->post());

            $investor_password_service->execute($investor_password_command);

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

        $this->app->render('Pages/_investor_password.twig');
    }
}

// EOF
