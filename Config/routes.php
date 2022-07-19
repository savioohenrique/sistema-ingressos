<?php

use App\Controllers\ClientController;
use App\Controllers\CreatePaymentController;
use App\Controllers\GetPaymentController;

return [
    'GET' => [
        '/payment' => GetPaymentController::class,
    ],
    'POST' => [
        '/client' => ClientController::class,
        '/payment' => CreatePaymentController::class,
    ]
];
