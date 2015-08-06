<?php


namespace Mabes\Controllers;

use Mabes\Entity\Member;

class AdminAccountController extends BaseController
{
    public function getListAccount()
    {
        $data["accounts"] = $this->app->em->getRepository("Mabes\\Entity\\Member")->findAll();
        $this->app->render('Pages/_admin_accounts.twig', $data);
    }

    public function getEditAccount($account_id = 0)
    {
        $account_detail = $this->app->em->getRepository("Mabes\\Entity\\Member")->find($account_id);
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha(),
                "account" => $account_detail
            ]
        );

        $this->app->render('Pages/_edit_account.twig');
    }

    public function postEditAccount($account_id = 0)
    {
        try {
            if ($this->app->session->phrase != $this->app->request->post("captcha")) {
                throw new \DomainException("Captcha yang anda masukkan salah!");
            }
            $transfer = new Member();
            $transfer->massAssignment($this->app->request->post());

            $this->app->em->persist($transfer);
            $this->app->em->merge($transfer);
            $this->app->em->flush();

            $data["accounts"] = $this->app->em->getRepository("Mabes\\Entity\\Member")->findAll();
            $this->app->render('Pages/_admin_accounts.twig', $data);

        } catch (\DomainException $e) {
            $this->validationMessage(
                [
                    "custom" => $e->getMessage()
                ]
            );
        }

        $account_detail = $this->app->em->getRepository("Mabes\\Entity\\Member")->find($account_id);
        $this->app->view()->appendData(
            [
                "captcha" => $this->buildCaptcha(),
                "account" => $account_detail
            ]
        );

        $this->app->render('Pages/_edit_account.twig');
    }
}

// EOF
