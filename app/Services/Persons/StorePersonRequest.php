<?php

namespace App\Services\Persons;

class StorePersonRequest
{
    private string $name;
    private string $surname;
    private string $personalCode;
    private int $age;
    private string $address;
    private string $description;

    public function __construct(string $name, string $surname, string $personalCode, int $age, string $address, string $description)
   {
       $this->name = $name;
       $this->surname = $surname;
       $this->personalCode = $personalCode;
       $this->age = $age;
       $this->address = $address;
       $this->description = $description;
   }


    public function getName(): string
    {
        return $this->name;
    }


    public function getSurname(): string
    {
        return $this->surname;
    }


    public function getPersonalCode(): string
    {
        return $this->personalCode;
    }


    public function getAddress(): string
    {
        return $this->address;
    }


    public function getAge(): int
    {
        return $this->age;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

}