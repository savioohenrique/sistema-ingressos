<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Lot")
 */
class Lot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private string $id;
    /**
     * @ORM\Column(type="text")
     */
    private $value;
    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;
    /**
     * @ORM\Column(type="integer")
     */
    private int $reserved;
    /**
     * @ORM\Column(type="integer")
     */
    private int $purchased;
    /**
     * @ORM\Column(type="string")
     */
    private string $status;
    /**
     * @ORM\Column(type="string")
     */
    private string $start_date;
    /**
     * @ORM\Column(type="string")
     */
    private string $finish_date;
    
    public function __construct(
        string $value,
        int $quantity,
        int $reserved,
        int $purchased,
        string $status,
        string $start_date,
        string $finish_date
    ) {
        $this->id = uniqid('L', true);
        $this->value = $value;
        $this->quantity = $quantity;
        $this->reserved = $reserved;
        $this->purchased = $purchased;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->finish_date = $finish_date;
    }

    public function getId(){
        return $this->id;
    }

    public function getValue(){
        return $this->value;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function getQuantityReserved(){
        return $this->reserved;
    }

    public function getQuantityPurchased(){
        return $this->purchased;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStartDate(){
        return $this->start_date;
    }
    
    public function getFinishDate(){
        return $this->finish_date;
    }

    public function reserveTickets(int $ticketsQuantity): void 
    {
        if ($ticketsQuantity <= $this->quantity) {
            $this->quantity -= $ticketsQuantity;
            $this->reserved += $ticketsQuantity;
        }
    }
}
