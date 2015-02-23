<?php


namespace Mabes\Controllers;

class AdminInvestorPasswordController extends BaseController
{
    public function getAdminInvestorPasswords()
    {
        $data["investor_password"] = $this->app->em->getRepository("Mabes\\Entity\\InvestorPassword")->findAll();
        $this->app->render('Pages/_admin_investor_password.twig', $data);
    }
}

// EOF
