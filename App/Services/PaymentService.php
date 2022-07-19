<?php

namespace App\Services;

use App\DTO\PaymentData;
use App\Entity\Lot;
use App\Entity\Payment;
use DateInterval;
use DateTime;
use App\Repository\LotRepository;
use App\Repository\PaymentRepository;

class PaymentService
{
    private const EXPIRATION_INTERVAL = '3 days';

    private PaymentRepository $paymentRepository;

    public function __construct()
    {
        $this->paymentRepository = new PaymentRepository();
    }

    public function createPayment(PaymentData $paymentData)
    {
        $today = new DateTime('NOW');
        $expirationDate = $this->setExpirationDate($today);
        $status = 'pending';

        $lotRepository = new LotRepository();
        $lot = $lotRepository->getLotById($paymentData->getLot());
        if (is_null($lot)) {
            throw new \Exception('Invalid lot of tickets');
        }

        $value = $this->calculateTicketAmount($paymentData, $lot);
        $ticketsQuantity = (int) $paymentData->getTickets();
        
        if (!$this->isQuantityAvailable($ticketsQuantity, $lot)) {
            throw new \Exception('Cannot buy this quantity of tickets');
        }

        $payment = Payment::createFromPaymentData($value, $paymentData, $status, $today->format('Y-m-d'), $expirationDate->format('Y-m-d'));
        
        $this->paymentRepository->savePayment($payment);
        $this->reserveTickets($ticketsQuantity, $lot, $lotRepository);

        return $this->buildSucessfulResponse($payment);
    }

    public function getPayment(string $paymentId)
    {
        $payment = $this->paymentRepository->findPaymentById($paymentId);
        if (is_null($payment)) {
            throw new \Exception('Cannot find any payment for this payment id');
        }

        return $this->buildSucessfulResponse($payment);
    }

    private function setExpirationDate(Datetime $date): DateTime 
    {
        $interval = DateInterval::createFromDateString(self::EXPIRATION_INTERVAL);
        $expirationDate = (clone $date)->add($interval);
        return $expirationDate;
    }

    private function calculateTicketAmount(PaymentData $paymentData, Lot $lot)
    {
        $ticketValue = (float) $lot->getValue();
        $totalAmount = $ticketValue *  $paymentData->getTickets();

        return number_format($totalAmount, 2, '.');
    }

    private function isQuantityAvailable(int $ticketQuantity, Lot $lot): bool
    {
        return $ticketQuantity <= (int) $lot->getQuantity();
    }

    private function reserveTickets(int $ticketsQuantity, Lot $lot, LotRepository $lotRepository): void
    {
        $lotRepository->reserveTickets($lot, $ticketsQuantity);
    } 

    private function buildSucessfulResponse(Payment $payment)
    {
        return <<<JSON
{
    "payment_id": "{$payment->getId()}",
    "payment_amount": "{$payment->getValue()}",
    "client_id": "{$payment->getClientId()}",
    "event_id": "{$payment->getEventId()}",
    "tickets": "{$payment->getTickets()}",
    "payment_status": "{$payment->getStatus()}",
    "payment_expiration_date": "{$payment->getexpirationDate()}"
}
JSON;
    }
}