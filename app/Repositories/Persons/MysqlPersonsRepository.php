<?php

namespace App\Repositories\Persons;

use App\Config;
use App\Models\Person;
use App\Models\PersonCollection;
use Medoo\Medoo;

class MysqlPersonsRepository implements PersonsRepository
{
    private Medoo $database;

    public function __construct()
    {
        $dbConfig = Config::getInstance()->get('db');
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'person_registry',
            'server' => 'localhost',
            'username' => $dbConfig['user'],
            'password' => $dbConfig['password']
        ]);
    }


    public function add(Person $person): void
    {
        $this->database->insert('registryPersons', [
            'name' => $person->getName(),
            'surname' => $person->getSurname(),
            'personal_code' => $person->getPersonalCode(),
            'age' => $person->getAge(),
            'address' => $person->getAddress(),
            'description' => $person->getDescription()
        ]);
    }

    public function get(string $key, string $parameter): PersonCollection
    {
        $foundPersons = new PersonCollection;
        $foundPersonsArray = $this->database->select(
            'registryPersons',
            ['name', 'surname', 'personal_code', 'age', 'address', 'description'],
            [$key."[~]" => $parameter]);

        foreach ($foundPersonsArray as $person) {
            $foundPersons->add(
                new Person(
                    $person['name'],
                    $person['surname'],
                    $person['personal_code'],
                    $person['age'],
                    $person['address'],
                    $person['description'],
                )
            );
        }
        return $foundPersons;
    }

    public function delete(Person $person): void
    {
        $this->database->delete("registryPersons", [

            "personal_code" => $person->getPersonalCode(),
        ]);
    }

    public function edit(Person $person, $request): void
    {
        $this->database->update("registryPersons", [
            "description" => $request
        ], [
            "personal_code" => $person->getPersonalCode()
        ]);
    }


}