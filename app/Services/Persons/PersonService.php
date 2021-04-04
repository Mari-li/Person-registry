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
        $person = new Person($request->getName(), $request->getSurname(), $request->getPersonalCode(), $request->getDescription());
        $this->personsRepository->save($person);
        $this->messages->registerMessage($person);
        return $person;
    }

    public function searchPersons($mysqlKey, string $requestParameter): PersonCollection
    {
        $persons = $this->personsRepository->get($mysqlKey, $requestParameter);
        if (empty($persons->getAll())) {
            $this->messages->notFoundMessage($mysqlKey, $requestParameter);
            exit;
        }
        return $persons;
    }

    public function deletePerson(Person $person): void
    {
        $this->personsRepository->delete($person);
        $this->messages->deleteMessage($person);
    }

    public function updatePersonsInformation(Person $person, $request): void
    {
        $this->personsRepository->edit($person, $request);
        $this->messages->updateMessage($person);
    }

}