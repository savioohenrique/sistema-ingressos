<?php

declare(strict_types=1);

namespace Src\Entities;

use DateTime;

class Payment
{
    private string $id;
    private string $value;
    private Client $client;
    private Customer $customer;
    private Lot $lot;
    private int $tickets;
    private string $eventId;
    private string $status;
    private DateTime $date;
    private DateTime $expirationDate;
    
    public function __construct(
        Client $client,
        Customer $customer,
        Lot $lot,
        int $tickets,
        string $eventId,
        string $status,
        DateTime $date,
        DateTime $expirationDate
    ) {
        $this->id = uniqid('P', true);
        $this->client = $client;
        $this->customer = $customer;
        $this->lot = $lot;
        $this->tickets = $tickets;
        $this->eventId = $eventId;
        $this->status = $status;
        $this->date = $date;
        $this->expirationDate = $expirationDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getLot(): Lot
    {
        return $this->lot;
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
