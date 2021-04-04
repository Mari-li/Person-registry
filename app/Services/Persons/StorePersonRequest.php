<?php

namespace App\Services\Persons;

class StorePersonRequest
{
    private string $name;
    private string $surname;
    private string $personalCode;
    private string $description;

    public function __construct(string $name, string $surname, string $personalCode, string $description )
   {
       $this->setName($name);
       $this->setSurname($surname);
       $this->personalCode = $personalCode;
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


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = ucfirst(strtolower($name));
    }

    public function setSurname($surname)
    {
        $this->surname = ucfirst(strtolower($surname));
    }

}