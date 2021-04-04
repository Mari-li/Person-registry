<?php

namespace App\Models;

class Person
{
    private string $name;
    private string $surname;
    private string $personalCode;
    private ?string $description;
    public function __construct(string $name, string $surname, string $personalCode, ?string $description='No information available')
    {
        $this->name = $name;
        $this->surname = $surname;
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


    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

}