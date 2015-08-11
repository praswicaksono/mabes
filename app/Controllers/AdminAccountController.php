<?php


namespace Mabes\Controllers;

use Mabes\Entity\Member;
use Mabes\Service\Command\EditMemberCommand;

class AdminAccountController extends BaseController
{
    public function getListAccount()
    {
        $data["accounts"] = $this->app->em->getRepository("Mabes\\Entity\\Member")->findAll();
        $this->app->render('Pages/_admin_accounts.twig', $data);
    }

    public function getEditAccount($account_id = 0)
    {
        $account_detail = $this->app->em->getRepository("Mabes\\Entity\\Member")->findBy(['account_id' => $account_id]);

        $this->populateForm($account_detail);

        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha()
            ]
        );

        $this->app->render('Pages/_admin_edit_account.twig');
    }

    public function postEditAccount($account_id = 0)
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }

            $member_service = $this->app->container->get("EditMemberService");

            $member_edit_command = new EditMemberCommand();
            $member_edit_command->massAssignment($this->app->request->post());

            $member_service->execute($member_edit_command);

            $this->app->view()->appendData(
                [
                    "isSuccess" => true,
                    "successTitle" => "Berhasil",
                    "successMessage" => "Account Number " . $account_id . " berhasil di update"
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
        $this->app->render('Pages/_admin_edit_account.twig');
    }
}

// EOF
