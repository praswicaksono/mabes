<?php


namespace Mabes\Controllers;

class AdminAccountController extends BaseController
{
    public function getListAccount()
    {
        $data["accounts"] = $this->app->em->getRepository("Mabes\\Entity\\Member")->findAll();
        $this->app->render('Pages/_admin_accounts.twig', $data);
    }
}

// EOF
