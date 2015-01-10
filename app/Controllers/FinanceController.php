<?php


namespace Mabes\Controllers;


class FinanceController extends BaseController
{
    public function index()
    {
        $this->app->render('Pages/_finance.twig');
    }
    public function deposit()
    {
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
