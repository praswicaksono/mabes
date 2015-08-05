<?php

namespace Mabes\Controllers;

use Mabes\Entity\Withdrawal;
use Mabes\Service\Command\WithdrawalMarkAsDoneCommand;
use Mabes\Service\Command\WithdrawalMarkAsFailedCommand;

class AdminWithdrawalController extends BaseController
{
    public function getAdminWithdrawal()
    {
        $data["withdrawal"] = $this->app->em->getRepository("Mabes\\Entity\\Withdrawal")
            ->findBy(["status" => Withdrawal::STATUS_OPEN]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_admin_withdrawal.twig', $data);
    }

    public function getProcessedWithdrawal()
    {
        $data["withdrawal"] = $this->app->em->getRepository("Mabes\\Entity\\Withdrawal")
            ->findBy(["status" => Withdrawal::STATUS_PROCESSED], ["withdrawal_id" => "DESC"]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_complete_admin_withdrawal.twig', $data);
    }

    public function getDeletedWithdrawal()
    {
        $data["withdrawal"] = $this->app->em->getRepository("Mabes\\Entity\\Withdrawal")
            ->findBy(["status" => Withdrawal::STATUS_FAILED], ["withdrawal_id" => "DESC"]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_deleted_admin_withdrawal.twig', $data);
    }

    public function getAdminWithdrawalMarkAsFailed($withdrawal_id = 0)
    {
        try {
            $withdrawal_failed_service = $this->app->container->get("WithdrawalMarkAsFailedService");

            $withdrawal_failed_command = new WithdrawalMarkAsFailedCommand();
            $withdrawal_failed_command->massAssignment([
                "withdrawal_id" => $withdrawal_id
            ]);

            $withdrawal_failed_service->execute($withdrawal_failed_command);
            $this->app->response->redirect("{$this->app->config["base_url"]}administrator/withdrawal");
        } catch (\DomainException $e) {
            echo $e->getMessage();
        }
    }

    public function getAdminWithdrawalMarkAsDone($withdrawal_id = 0)
    {
        try {
            $withdrawal_done_service = $this->app->container->get("WithdrawalMarkAsDoneService");

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