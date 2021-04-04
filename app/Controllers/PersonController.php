<?php

namespace App\Controllers;

use App\Services\Persons\StorePersonRequest;
use App\Services\Persons\PersonService;
use InvalidArgumentException;

class PersonController
{
    private PersonService $service;

    public function __construct(PersonService $service)
    {
        $this->service = $service;
    }


    public function register(): void
    {
        if (isset($_POST['register'])) {
            try {
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $personalCode = $_POST['personalCode'];
                $description = $_POST['description'];

                if (!ctype_alpha($name)) {
                    throw new InvalidArgumentException('Invalid name.');
                }
                if (!ctype_alpha($surname)) {
                    throw new InvalidArgumentException('Invalid surname.');
                }
                if (!preg_match('/^[0-9 -]*$/', $personalCode)) {
                    throw new InvalidArgumentException('Invalid personal code format.');
                } else {
                    $this->service->addPerson(
                        new StorePersonRequest(
                            $name,
                            $surname,
                            $personalCode,
                            $description
                        )
                    );
                }
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function search(): void
    {
        $mysqlKey = key($_POST);
        $foundedPersons = $this->service->searchPersons($mysqlKey, $_POST[$mysqlKey]);
        require_once 'app/Views/personsInfoView.php';
    }


    public function delete(): void
    {
        $request = trim($_GET['delete']);
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->deletePerson($person);
    }


    public function updateForm(): void
    {
        $request = trim($_GET['update']);
        $mysqlKey = key($_GET);
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        require_once 'app/Views/updatingFormView.php';
    }

    public function update(): void
    {
        $request = trim($_POST['update']);
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->updatePersonsInformation($person, $_POST['description']);
    }
}

