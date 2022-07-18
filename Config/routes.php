<?php

use App\Controllers\ClientController;
use App\Controllers\CreatePaymentController;

return [
    '/client' => ClientController::class,
    '/payment' => CreatePaymentController::class,
];
