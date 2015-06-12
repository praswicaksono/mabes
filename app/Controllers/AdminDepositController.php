<?php


namespace Mabes\Controllers;

use Mabes\Entity\Deposit;
use Mabes\Service\Command\DepositMarkAsDoneCommand;

class AdminDepositController extends BaseController
{
    public function getAdminDeposits()
    {
        $data["deposits"] = $this->app->em->getRepository("Mabes\\Entity\\Deposit")
            ->findBy(["status" => Deposit::STATUS_OPEN]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_admin_deposit.twig', $data);
    }

    public function getProcessedDeposit()
    {
        $data["deposits"] = $this->app->em->getRepository("Mabes\\Entity\\Deposit")
            ->findBy(["status" => Deposit::STATUS_PROCESSED]);
        $data["base_url"] = $this->app->config["base_url"];
        $this->app->render('Pages/_complete_admin_deposit.twig', $data);
    }

    public function getAdminDepositMarkAsDone($deposit_id = 0)
    {
        try {
            $depo_done_service = $this->app->container->get("DepositMarkAsDoneService");

            $depo_done_command = new DepositMarkAsDoneCommand();
            $depo_done_command->massAssignment([
                "deposit_id" => $deposit_id
            ]);

            $depo_done_service->execute($depo_done_command);
            $this->app->response->redirect("{$this->app->config["base_url"]}administrator/deposits");
        } catch (\DomainException $e) {
            echo $e->getMessage();
        }
    }
}

// EOF
