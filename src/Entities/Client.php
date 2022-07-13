<?php

declare(strict_types=1);

namespace Src\Entities;

class Client extends User
{
    private string $profile = 'USER';
    
    public function __construct(string $firstName, string $lastName, string $email, string $password)    
    {
        parent::__construct($firstName, $lastName, $email, $email, $password);
    }

    public function getProfile(): string
    {
        return $this->profile;
    }
}
