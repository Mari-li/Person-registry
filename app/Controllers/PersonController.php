<?php

namespace App\Controllers;

use App\Services\Persons\StorePersonRequest;
use App\Services\Persons\PersonService;
use InvalidArgumentException;
use Twig\Environment;

class PersonController
{
    private PersonService $service;
    private Environment $twig;

    public function __construct(PersonService $service, Environment $twig)
    {
        $this->service = $service;
        $this->twig = $twig;
    }


    public function register(): void
    {
        if (isset($_POST['register'])) {
            try {
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $personalCode = $_POST['personalCode'];
                $age = $_POST['age'];
                $address = $_POST['address'];
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
                            $age,
                            $address,
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
        $foundedPersons = ($this->service->searchPersons($mysqlKey, $_POST[$mysqlKey]))->getAll();
        $this->twig->display('personsInfo.twig',['persons'=> $foundedPersons]);
    }


    public function delete(): void
    {
        $request = $_GET['delete'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->deletePerson($person);
    }


    public function updateForm(): void
    {
        $request = $_GET['update'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->twig->display('update.twig', ['person' => $person]);
       // require_once 'app/Views/updatingFormView.php';
    }

    public function update(): void
    {
        $request = $_POST['update'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->updatePersonsInformation($person, $_POST['description']);
    }
}

