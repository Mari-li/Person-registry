<?php

namespace App\Models;

class PersonCollection
{
    private array $registryPersons = [];

    public function add(Person $person): void
    {
        $this->registryPersons[] = $person;
    }

    public function getAll(): array
    {
        return $this->registryPersons;

    }

    public function getOne($personalCode): ?Person
    {
        foreach ($this->getAll() as $onePerson) {
            if ($onePerson->getPersonalCode() == $personalCode) {
                $person = new Person(
                    $onePerson->getName(),
                    $onePerson->getSurname(),
                    $onePerson->getPersonalCode(),
                    $onePerson->getAge(),
                    $onePerson->getAddress(),
                    $onePerson->getDescription());
            }
        }
        return $person;
    }


}