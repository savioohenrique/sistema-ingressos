<?php

declare(strict_types=1);

namespace App\Entity;

use App\DTO\PaymentData;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Payment")
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private string $id;
    /**
     * @ORM\Column(type="string")
     */
    private float $value;
    /**
     * @ORM\Column(type="string")
     */
    private string $client_id;
    /**
     * @ORM\Column(type="string")
     */
    private string $customer_id;
    /**
     * @ORM\Column(type="string")
     */
    private string $lot_id;
    /**
     * @ORM\Column(type="integer")
     */
    private int $tickets;
    /**
     * @ORM\Column(type="string")
     */
    private string $event_id;
    /**
     * @ORM\Column(type="string")
     */
    private string $status;
    /**
     * @ORM\Column(type="string")
     */
    private string $date;
    /**
     * @ORM\Column(type="string")
     */
    private string $expiration_date;
    
    public function __construct(
        $value,
        string $client_id,
        string $customer_id,
        string $event_id,
        string $lot_id,
        int $tickets,
        string $status,
        string $date,
        string $expiration_date
    ) {
        $this->id = uniqid('P', true);
        $this->value = $value;
        $this->client_id = $client_id;
        $this->customer_id = $customer_id;
        $this->event_id = $event_id;
        $this->lot_id = $lot_id;
        $this->tickets = $tickets;
        $this->status = $status;
        $this->date = $date;
        $this->expiration_date = $expiration_date;
    }

    public static function createFromPaymentData($value, PaymentData $paymentData, string $status, string $date, string $expiration_date)
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
            $expiration_date
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getLot(): string
    {
        return $this->lot_id;
    }

    public function getTickets(): int
    {
        return $this->tickets;
    }

    public function getEventId(): string
    {
        return $this->event_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    
    public function getexpirationDate(): string
    {
        return $this->expiration_date;
    }   
}
