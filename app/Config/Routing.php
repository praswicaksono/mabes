<?php

return [
    [
        "http_method" => "get",
        "route" => "/",
        "class" => "\\Mabes\\Controllers\\IndexController",
        "method" => "index",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/rebates",
        "class" => "\\Mabes\\Controllers\\RebatesController",
        "method" => "index",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "index",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/deposit",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "deposit",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/withdrawal",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "withdrawal",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/transfer-balance",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "transferBalance",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/transaction-status",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "transactionStatus",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/withdrawal",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "withdrawal",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/bonus",
        "class" => "\\Mabes\\Controllers\\FinanceController",
        "method" => "withdrawal",
        "auth" => false
    ],

    // ADMIN AREA

    [
        "http_method" => "get",
        "route" => "/login",
        "class" => "\\Mabes\\Controllers\\AdminController",
        "method" => "login",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/login",
        "class" => "\\Mabes\\Controllers\\AdminController",
        "method" => "login",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/administrator",
        "class" => "\\Mabes\\Controllers\\AdminController",
        "method" => "index",
        "auth" => false
    ]
];

// EOF
