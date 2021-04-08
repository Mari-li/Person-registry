<?php

namespace App\Services\Persons;
use App\Messages;
use App\Models\Person;
use App\Models\PersonCollection;
use App\Repositories\Persons\PersonsRepository;

class PersonService
{
    private PersonsRepository $personsRepository;
    private Messages $messages;

    public function __construct(PersonsRepository $personsRepository)
    {
        $this->personsRepository = $personsRepository;
        $this->messages = new Messages;
    }

    public function addPerson(StorePersonRequest $request): Person
    {
        $person = new Person(
            $request->getName(),
            $request->getSurname(),
            $request->getPersonalCode(),
            $request->getAge(),
            $request->getAddress(),
            $request->getDescription()
        );
        $this->personsRepository->save($person);
        return $person;
    }

    public function searchPersons($mysqlKey, string $requestParameter): PersonCollection
    {
        return $this->personsRepository->get($mysqlKey, $requestParameter);

    }

    public function deletePerson(Person $person): void
    {
        $this->personsRepository->delete($person);
    }

    public function updatePersonsInformation(Person $person, $request): void
    {
        $this->personsRepository->edit($person, $request);
    }

}