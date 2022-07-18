<?php

declare(strict_types=1);

namespace Src\Entities;

use DateTime;

class Event
{
    private string $id;
    private string $name;
    private Address $address;
    private string $classification;
    private string $tag;
    private string $description;
    private DateTime $startDate;
    private DateTime $finishDate;
    /** @var Lot[]*/
    private array $lots;
    
    public function __construct(
        string $name,
        Address $address,
        string $classification,
        string $tag,
        string $description,
        DateTime $startDate,
        DateTime $finishDate,
        array $lots
    ) {
        $this->id = uniqid('Ev', true);
        $this->name = $name;
        $this->address = $address;
        $this->classification = $classification;
        $this->tag = $tag;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
        $this->lots = $lots;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getClassification(): string
    {
        return $this->classification;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getFinishDate(): DateTime
    {
        return $this->finishDate;
    }

    public function getLosts(): array
    {
        return $this->lots;
    }
}
