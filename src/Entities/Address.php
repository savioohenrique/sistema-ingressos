<?php

declare(strict_types=1);

namespace Src\Entities;

class Address
{
    private string $name;
    private string $street;
    private string $number;
    private string $zipCode;
    private string $district;
    private string $city;
    private string $state;
    private string $country;
    
    public function __construct(
        string $name,
        string $street,
        string $number,
        string $zipCode,
        string $district,
        string $city,
        string $state,
        string $country
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->number = $number;
        $this->zipCode = $zipCode;
        $this->district = $district;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
