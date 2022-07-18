<?php

namespace App\Services;

use App\DTO\PaymentData;
use App\Entity\Payment;
use DateInterval;
use DateTime;
use App\Repository\LotRepository;

class PaymentService
{
    private const EXPIRATION_INTERVAL = '3 days';

    public static function createPayment(PaymentData $paymentData)
    {
        $today = new DateTime('NOW');
        $expirationDate = self::setExpirationDate($today);
        $status = 'pending';
        $value = self::calculateTicketAmount($paymentData);

        $payment = Payment::createFromPaymentData($value, $paymentData, $status, $today->format('Y-m-d'), $expirationDate->format('Y-m-d'));
        
        //savePayment

        return $payment;
    }

    private static function setExpirationDate(Datetime $date): DateTime 
    {
        $interval = DateInterval::createFromDateString(self::EXPIRATION_INTERVAL);
        $expirationDate = (clone $date)->add($interval);
        return $expirationDate;
    }

    private static function calculateTicketAmount(PaymentData $paymentData)
    {
        $lot = (new LotRepository())->getLotById($paymentData->getLot());
        $ticketValue = (float) $lot->getValue();
        
        return $ticketValue *  $paymentData->getTickets();
    }
}