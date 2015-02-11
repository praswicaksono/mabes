<?php


namespace Mabes\Controllers;

use Mabes\Service\Command\CreateMemberCommand;

class RegistrationController extends BaseController
{
    public function getRegistration()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_register.twig');
    }

    public function postRegistration()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $registration_service = $this->app->container->get("CreateMemberService");

            $user_registration_command = new CreateMemberCommand();
            $user_registration_command->massAssignment($this->app->request->post());

            $registration_service->execute($user_registration_command);

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Berhasil",
                    "successMessage" => "Data berhasil dimasukkan kedalam database, tim kami akan memvalidasi data anda"
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

        $this->app->render('Pages/_register.twig');
    }
}

// EOF
