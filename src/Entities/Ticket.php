<?php

declare(strict_types=1);

namespace Src\Entities;

use DateTime;

class Ticket
{
    private string $id;
    private Client $client;
    private Lot $lot;
    private Event $event;
    private string $status;
    private DateTime $date;

    public function __construct(
        Client $client,
        Lot $lot,
        Event $event,
        string $status,
        DateTime $date
    ) {
        $this->id = uniqid('T', true);
        $this->client = $client;
        $this->lot = $lot;
        $this->event = $event;
        $this->status = $status;
        $this->date = $date;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getLot(): Lot
    {
        return $this->lot;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}
