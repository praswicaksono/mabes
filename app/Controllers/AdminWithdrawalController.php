<?php

namespace Mabes\Controllers;

use Mabes\Entity\Withdrawal;
use Mabes\Service\Command\WithdrawalMarkAsDoneCommand;

class AdminWithdrawalController extends BaseController
{
    public function getAdminWithdrawal()
    {
        $data["withdrawal"] = $this->app->em->getRepository("Mabes\\Entity\\Withdrawal")
            ->findBy(["status" => Withdrawal::STATUS_OPEN]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_admin_withdrawal.twig', $data);
    }

    public function getAdminWithdrawalMarkAsDone($withdrawal_id = 0)
    {
        try {
            $withdrawal_done_service = $this->app->container->get("DepositMarkAsDoneService");

            $withdrawal_done_command = new WithdrawalMarkAsDoneCommand();
            $withdrawal_done_command->massAssignment([
                "withdrawal_id" => $withdrawal_id
            ]);

            $withdrawal_done_service->execute($withdrawal_done_command);
            $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
        } catch (\DomainException $e) {
            echo $e->getMessage();
        }
    }
}