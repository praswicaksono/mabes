<?php

namespace Mabes\Controllers;

use Mabes\Entity\Withdrawal;

class AdminWithdrawalController extends BaseController
{
    public function getAdminWithdrawal()
    {
        $data["withdrawal"] = $this->app->em->getRepository("Mabes\\Entity\\Withdrawal")
            ->findBy(["status" => Withdrawal::STATUS_OPEN]);

        $this->app->render('Pages/_admin_withdrawal.twig', $data);
    }
}