<?php


namespace Mabes\Controllers;

use Mabes\Entity\Deposit;

class AdminDepositController extends BaseController
{
    public function getAdminDeposits()
    {
        $data["deposits"] = $this->app->em->getRepository("Mabes\\Entity\\Deposit")
            ->findBy(["status" => Deposit::STATUS_OPEN]);
        $this->app->render('Pages/_admin_deposit.twig', $data);
    }
}

// EOF
