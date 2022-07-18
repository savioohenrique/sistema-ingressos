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

    public static function createPayment(PaymentData $paymentData)
    {
        $today = new DateTime('NOW');
        $expirationDate = self::setExpirationDate($today);
        $status = 'pending';

        $lotRepository = new LotRepository();
        $lot = $lotRepository->getLotById($paymentData->getLot());

        $value = self::calculateTicketAmount($paymentData, $lot);
        $ticketsQuantity = (int) $paymentData->getTickets();
        
        if (!self::isQuantityAvailable($ticketsQuantity, $lot)) {
            throw new \Exception('Cannot buy this quantity of tickets');
        }

        $payment = Payment::createFromPaymentData($value, $paymentData, $status, $today->format('Y-m-d'), $expirationDate->format('Y-m-d'));
        
        (new PaymentRepository())->savePayment($payment);
        self::updateLotQuantity($ticketsQuantity, $lot, $lotRepository);

        return $payment;
    }

    private static function setExpirationDate(Datetime $date): DateTime 
    {
        $interval = DateInterval::createFromDateString(self::EXPIRATION_INTERVAL);
        $expirationDate = (clone $date)->add($interval);
        return $expirationDate;
    }

    private static function calculateTicketAmount(PaymentData $paymentData, Lot $lot)
    {
        $ticketValue = (float) $lot->getValue();
        
        return $ticketValue *  $paymentData->getTickets();
    }

    private static function isQuantityAvailable(int $ticketQuantity, Lot $lot): bool
    {
        return $ticketQuantity <= (int) $lot->getQuantity();
    }

    private static function updateLotQuantity(int $ticketsQuantity, Lot $lot, LotRepository $lotRepository): void
    {
        $lotRepository->reserveTickets($lot, $ticketsQuantity);
    } 
}