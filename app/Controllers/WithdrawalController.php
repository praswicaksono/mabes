<?php


namespace Mabes\Controllers;

use Mabes\Service\Command\CreateWithdrawalCommand;

class WithdrawalController extends BaseController
{
    public function getWithdrawal()
    {
        if ($this->app->request->isGet()) {

            $this->app->view()->appendData(
                [
                    "captcha" => $this->buildCaptcha()
                ]
            );

            $this->app->render('Pages/_withdrawal.twig');
        }
    }

    public function postWithdrawal()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $withdrawal_service = $this->app->container->get("CreateWithdrawalService");

            $withdrawal_command = new CreateWithdrawalCommand();
            $withdrawal_command->massAssignment($this->app->request->post());

            $ticket = $withdrawal_service->execute($withdrawal_command);

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Berhasil",
                    "successMessage" => "Tiket withdrawal anda : #{$ticket}"
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

        $this->app->render('Pages/_withdrawal.twig');
    }
}

// EOF
