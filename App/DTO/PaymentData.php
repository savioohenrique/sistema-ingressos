<?php

namespace App\DTO;

use Psr\Http\Message\RequestInterface;

class PaymentData
{
    private array $payload;
    
    private function __construct(array $payload) {
        $this->payload = $payload;
        $this->validateSucessfulRequest();
	}

    public static function fromHttpRequest(RequestInterface $request): self {
        // echo "PaymentData: " . $request->getBody(). "<br>";
		$jsonDecoder = new JsonDecoder($request->getBody());
		return new self($jsonDecoder->decodeJsonToArray());
	}

    private function validateSucessfulRequest(): void 
    {
        if (empty($this->getClient())) {
            throw new \Exception('The client must be provided');
        }
        if (empty($this->getCustomer())) {
            throw new \Exception('The customer must be provided');
        }
        if (empty($this->getEvent())) {
            throw new \Exception('The event must be provided');
        }
        if (empty($this->getLot())) {
            throw new \Exception('The lot of the event must be provided');
        }
        if (empty($this->getTickets())) {
            throw new \Exception('The tickets quantity must be provided');
        }
    }

    public function getClient(): string
    {
        return $this->payload['client'] ?? '';
    }

    public function getCustomer(): string
    {
        return $this->payload['customer'] ?? '';
    }

    public function getLot(): string
    {
        return $this->payload['lot'] ?? '';
    }

    public function getTickets(): int
    {
        return (int) $this->payload['tickets_quantity'] ?? '';
    }

    public function getEvent(): string
    {
        return $this->payload['event'] ?? '';
    }
}