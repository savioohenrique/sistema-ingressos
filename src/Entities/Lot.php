<?php

declare(strict_types=1);

namespace Src\Entities;

use DateTime;

class Lot
{
    private int $id;
    private string $value;
    private int $quantity;
    private int $quantityReserved;
    private DateTime $startDate;
    private DateTime $finishDate;
    
    public function __construct(
        string $value,
        int $quantity,
        int $quantityReserved,
        DateTime $startDate,
        DateTime $finishDate
    ) {
        $this->id = uniqid('L', true);
        $this->value = $value;
        $this->quantity = $quantity;
        $this->quantityReserved = $quantityReserved;
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
    }

    public function getId(){
        $this->id;
    }

    public function getValue(){
        $this->value;
    }

    public function getQuantity(){
        $this->quantity;
    }

    public function getQuantityReserved(){
        $this->quantityReserved;
    }

    public function getStartDate(){
        $this->startDate;
    }
    
    public function getFinishDate(){
        $this->finishDate;
    }   
}
