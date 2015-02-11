<?php


namespace Mabes\Controllers;


use Mabes\Service\Command\ClaimRebateCommand;

class ClaimRebatesController extends BaseController
{
    public function getClaimRebates()
    {
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_claim_rebates.twig');
    }

    public function postClaimRebates()
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $deposit_service = $this->app->container->get("ClaimRebateService");

            $claim_command = new ClaimRebateCommand();
            $claim_command->massAssignment($this->app->request->post());

            $deposit_service->execute($claim_command);

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Berhasil",
                    "successMessage" => "Rebate anda telah terkonfirmasi, jika anda ingin mengganti tujuan klaim silahkan hubungi CS kami"
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

        $this->app->render('Pages/_claim_rebates.twig');
    }
}

// EOF
