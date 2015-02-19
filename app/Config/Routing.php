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
        "route" => "/investor-password",
        "class" => "\\Mabes\\Controllers\\InvestorPasswordController",
        "method" => "getInvestorPassword",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/investor-password",
        "class" => "\\Mabes\\Controllers\\InvestorPasswordController",
        "method" => "postInvestorPassword",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/akun-islami",
        "class" => "\\Mabes\\Controllers\\IslamicAccountController",
        "method" => "getIslamicAccount",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/akun-islami",
        "class" => "\\Mabes\\Controllers\\IslamicAccountController",
        "method" => "postIslamicAccount",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/klaim-rebates",
        "class" => "\\Mabes\\Controllers\\ClaimRebatesController",
        "method" => "getClaimRebates",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/klaim-rebates",
        "class" => "\\Mabes\\Controllers\\ClaimRebatesController",
        "method" => "postClaimRebates",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/register",
        "class" => "\\Mabes\\Controllers\\RegistrationController",
        "method" => "getRegistration",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/register",
        "class" => "\\Mabes\\Controllers\\RegistrationController",
        "method" => "postRegistration",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/rebates",
        "class" => "\\Mabes\\Controllers\\RebatesController",
        "method" => "getRebates",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/rebates",
        "class" => "\\Mabes\\Controllers\\RebatesController",
        "method" => "postRebates",
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
        "route" => "/finance/deposit",
        "class" => "\\Mabes\\Controllers\\DepositController",
        "method" => "getDeposit",
        "auth" => false
    ],
    [
        "http_method" => "Post",
        "route" => "/finance/deposit",
        "class" => "\\Mabes\\Controllers\\DepositController",
        "method" => "postDeposit",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/withdrawal",
        "class" => "\\Mabes\\Controllers\\WithdrawalController",
        "method" => "getWithdrawal",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/finance/withdrawal",
        "class" => "\\Mabes\\Controllers\\WithdrawalController",
        "method" => "postWithdrawal",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/finance/transfer",
        "class" => "\\Mabes\\Controllers\\TransferController",
        "method" => "getTransfer",
        "auth" => false
    ],
    [
        "http_method" => "post",
        "route" => "/finance/transfer",
        "class" => "\\Mabes\\Controllers\\TransferController",
        "method" => "postTransfer",
        "auth" => false
    ],

    // ADMIN AREA

    [
        "http_method" => "get",
        "route" => "/auth/login",
        "class" => "\\Mabes\\Controllers\\AuthController",
        "method" => "getLogin",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/auth/logout",
        "class" => "\\Mabes\\Controllers\\AuthController",
        "method" => "getLogout",
        "auth" => true
    ],
    [
        "http_method" => "post",
        "route" => "/auth/login",
        "class" => "\\Mabes\\Controllers\\AuthController",
        "method" => "postLogin",
        "auth" => false
    ],
    [
        "http_method" => "get",
        "route" => "/administrator",
        "class" => "\\Mabes\\Controllers\\AdminController",
        "method" => "index",
        "auth" => true
    ],
    [
        "http_method" => "get",
        "route" => "/administrator/withdrawal",
        "class" => "\\Mabes\\Controllers\\AdminWithdrawalController",
        "method" => "getAdminWithdrawal",
        "auth" => true
    ],
    [
        "http_method" => "get",
        "route" => "/administrator/deposit",
        "class" => "\\Mabes\\Controllers\\AdminDepositController",
        "method" => "getAdminDeposit",
        "auth" => true
    ]
];

// EOF
