<?php


namespace Mabes\Controllers;

class AdminClaimRebatesController extends BaseController
{
    public function getAdminClaimRebates()
    {
        $data["claim_rebates"] =  $this->app->em->getRepository("Mabes\\Entity\\ClaimRebate")->findAll();
        $this->app->render('Pages/_admin_claim_rebates.twig', $data);
    }
}

// EOF
