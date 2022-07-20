<?php

namespace App\Commands;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use App\Services\PaymentService;

require __DIR__ . '/../../vendor/autoload.php';

$paymentRepository = new PaymentRepository();
$status = 'pending';
$payments = $paymentRepository->getPaymentByStatus($status);

$now = new \DateTime('now');
$today = $now->format('Y-m-d');

$paymentService = new PaymentService();

/** @var Payment $payment */
foreach ($payments as $key => $payment) {
    // Verificar expiration date 
    if (isPaymentExpired($payment->getexpirationDate(), $today)) {
        $payment = $paymentService->cancelPayment($payment);
        echo "#### Cancel Method #### " . PHP_EOL;
        echo "Payment: " . $payment->getId() . PHP_EOL;
        echo "Payment status: " . $payment->getStatus() . PHP_EOL . PHP_EOL;
    } else {
        $payment = $paymentService->queryPayment($payment);
        echo "#### Query Method #### " . PHP_EOL;
        echo "Payment: " . $payment->getId() . PHP_EOL;
        echo "Payment status: " . $payment->getStatus() . PHP_EOL . PHP_EOL;
    }
}

function isPaymentExpired(string $paymentDate, string $currentDate): bool
{
    return $currentDate > $paymentDate;
}