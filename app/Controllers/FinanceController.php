<?php


namespace Mabes\Controllers;

use Mabes\Entity\Deposit;

class FinanceController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_finance.twig');
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
