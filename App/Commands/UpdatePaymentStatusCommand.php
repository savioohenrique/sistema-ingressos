<?php

namespace App\Commands;

use App\Entity\Payment;
use App\Repository\PaymentRepository;

require __DIR__ . '/../../vendor/autoload.php';

$paymentRepository = new PaymentRepository();
$status = 'pending';
$payments = $paymentRepository->getPaymentByStatus($status);

/** @var Payment $payment */
foreach ($payments as $payment) {
    // Verificar expiration date 
    echo "Payment: " . $payment->getId() . PHP_EOL;
}
