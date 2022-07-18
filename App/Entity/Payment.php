<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\PaymentData;
use DateTime;

class Payment
{
    private string $id;
    private float $value;
    private string $clientId;
    private string $customerId;
    private string $lotId;
    private int $tickets;
    private string $eventId;
    private string $status;
    private string $date;
    private string $expirationDate;
    
    public function __construct(
        $value,
        string $clientId,
        string $customerId,
        string $eventId,
        string $lotId,
        int $tickets,
        string $status,
        string $date,
        string $expirationDate
    ) {
        $this->id = uniqid('P', true);
        $this->client = $clientId;
        $this->customerId = $customerId;
        $this->value = $value;
        $this->lot = $lotId;
        $this->tickets = $tickets;
        $this->eventId = $eventId;
        $this->status = $status;
        $this->date = $date;
        $this->expirationDate = $expirationDate;
    }

    public static function createFromPaymentData($value, PaymentData $paymentData, string $status, string $date, string $expirationDate)
    {
        return new self(
            $value,
            $paymentData->getClient(),
            $paymentData->getCustomer(),
            $paymentData->getEvent(),
            $paymentData->getLot(),
            $paymentData->getTickets(),
            $status,
            $date,
            $expirationDate
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getClient(): string
    {
        return $this->clientId;
    }

    public function getCustomer(): string
    {
        return $this->customerId;
    }

    public function getLot(): string
    {
        return $this->lotId;
    }

    public function getTickets(): int
    {
        return $this->tickets;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
    
    public function getexpirationDate(): DateTime
    {
        return $this->expirationDate;
    }   
}
