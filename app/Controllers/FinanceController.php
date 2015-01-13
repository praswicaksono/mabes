<?php


namespace Mabes\Controllers;

use Mabes\Entity\Deposit;

class FinanceController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_finance.twig');
    }

    public function deposit()
    {
        $data['bank'] = $this->app->em->getRepository("Mabes\\Entity\\Bank")->findAll();
        if ($this->app->request->isGet()) {
            $this->app->view()->appendData($data);
        }
        if ($this->app->request->isPost()) {
//            if (!$member = $this->app->em->getRepository("Mabes\\Entity\\Member")->findBy(['member_id' => $this->app->request->params('amount_idr')])) {
//                $this->app->view()->appendData([
//                    'isError' => true,
//                    'errorTitle' => "Deposit Notification",
//                    'errorMessage' => "Nomor login tidak terdaftar di bawah referral kami."
//                ]);

                    $deposit =new Deposit();
                    $deposit->setAmountUsd($this->app->request->params('amount_usd'));
                    $deposit->setAmountIdr($this->app->request->params('amount_idr'));
                    $deposit->setClient($this->app->request->params('client'));
                    $deposit->setBank($this->app->request->params('bank_id'));
                    $deposit->setBankFrom($this->app->request->params('bank_from'));
                    $deposit->setAccountNumber($this->app->request->params('account_number'));
                    $deposit->setAccountName($this->app->request->params('account_name'));
                    $deposit->setEmail($this->app->request->params('email'));
                    $deposit->setPhone($this->app->request->params('phone'));
                    $deposit->setStatus($deposit::STATUS_OPEN);

                    $this->app->em->persist($deposit);
                    $this->app->em->flush();

//            }

        }
        $this->app->render('Pages/_deposit.twig');
    }

    public function withdrawal()
    {
        $this->app->render('Pages/_withdrawal.twig');
    }

    public function transferBalance()
    {
        $this->app->render('Pages/_transferBalance.twig');
    }

    public function transactionStatus()
    {
        $this->app->render('Pages/_transactionStatus.twig');
    }
}

// EOF
