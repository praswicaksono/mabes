<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('perform withdrawal');

$I->amOnPage("finance/withdrawal");

$I->see("Withdrawal");
