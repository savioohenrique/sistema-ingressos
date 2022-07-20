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

    public function createPayment(PaymentData $paymentData): string
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

        $response = $this->sendCreatePaymentRequest($payment);
        
        $this->paymentRepository->savePayment($payment);
        $this->reserveTickets($ticketsQuantity, $lot, $lotRepository);

        return $this->buildSucessfulResponse($payment);
    }

    public function getPayment(string $paymentId): string
    {
        $payment = $this->paymentRepository->findPaymentById($paymentId);
        if (is_null($payment)) {
            throw new \Exception('Cannot find any payment for this payment id');
        }

        return $this->buildSucessfulResponse($payment);
    }

    public function cancelPayment(Payment $payment): Payment
    {
        $lotRepository = new LotRepository();
        $lot = $lotRepository->getLotById($payment->getLot());
        if (is_null($lot)) {
            throw new \Exception('Invalid lot of tickets');
        }

        $ticketsQuantity = (int) $payment->getTickets();
        
        $canceledPayment = $this->paymentRepository->cancelPayment($payment->getId());
        $this->cancelTickets($ticketsQuantity, $lot, $lotRepository);

        return $canceledPayment;
    }

    public function queryPayment(Payment $payment): Payment
    {
        $lotRepository = new LotRepository();
        $lot = $lotRepository->getLotById($payment->getLot());
        $ticketsQuantity = (int) $payment->getTickets();

        $response = $this->sendQueryRequest($payment->getId());
        $arrayResponse = json_decode($response, true);
        
        if (is_array($arrayResponse) && array_key_exists('payment_status', $arrayResponse) && $this->validateConfirmedPaymentStatus($arrayResponse['payment_status'])) {
            $payment = $this->paymentRepository->confirmPayment($payment->getId());
            $this->confirmTickets($ticketsQuantity, $lot, $lotRepository);
        }

        return $payment;
    }

    private function sendCreatePaymentRequest(Payment $payment): string|bool
    {
        $url = 'http://localhost:8081/public/create-payment';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $data = <<<DATA
        {
            "payment_id": "{$payment->getId()}",
            "payment_amount": "{$payment->getValue()}",
            "customer_id": "{$payment->getCustomerId()}",
            "client_id": "{$payment->getClientId()}",
            "payment_date": "{$payment->getDate()}",
            "payment_expiration_date": "{$payment->getExpirationDate()}"
        }
        DATA;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    private function sendQueryRequest(string $paymentId)
    {
        $url = 'http://localhost:8081/public/query-payment?id=' . $paymentId;
        $response = file_get_contents($url);

        return $response;
    }

    private function validateConfirmedPaymentStatus(string $paymentStatus): bool
    {
        return $paymentStatus === 'confirmed';
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

    private function cancelTickets(int $ticketsQuantity, Lot $lot, LotRepository $lotRepository): void
    {
        $lotRepository->cancelTickets($lot, $ticketsQuantity);
    }

    private function confirmTickets(int $ticketsQuantity, Lot $lot, LotRepository $lotRepository): void
    {
        $lotRepository->confirmTickets($lot, $ticketsQuantity);
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
    "payment_expiration_date": "{$payment->getExpirationDate()}"
}
JSON;
    }
}
