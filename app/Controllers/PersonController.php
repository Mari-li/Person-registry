<?php

namespace App\Controllers;

use App\Messages;
use App\Services\Persons\StorePersonRequest;
use App\Services\Persons\PersonService;
use InvalidArgumentException;
use Twig\Environment;

class PersonController
{
    private PersonService $service;
    private Environment $twig;
    private Messages $messages;

    public function __construct(PersonService $service, Environment $twig)
    {
        $this->service = $service;
        $this->twig = $twig;
        $this->messages = new Messages();
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
                    $person = new StorePersonRequest(
                        $name,
                        $surname,
                        $personalCode,
                        $age,
                        $address,
                        $description
                    );
                    $this->service->addPerson($person);
                    $this->twig->display('messages.twig', ['message' => $this->messages->registerMessage($person)]);
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
        if (empty($foundedPersons)) {
            $this->twig->display('messages.twig', ['message' => $this->messages->notFoundMessage($mysqlKey, $_POST[$mysqlKey])]);
        } else {
            $this->twig->display('personsInfo.twig', ['persons' => $foundedPersons]);
        }
    }


    public function delete(): void
    {
        $request = $_POST['delete'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->deletePerson($person);
        $this->twig->display('messages.twig', ['message' => $this->messages->deleteMessage($person)]);
    }


    public function updateForm(): void
    {
        $request = $_POST['update'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->twig->display('update.twig', ['person' => $person]);
    }

    public function update(): void
    {
        $request = $_POST['update'];
        $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
        $this->service->updatePersonsInformation($person, $_POST['description']);
        $this->twig->display('messages.twig', ['message' => $this->messages->updateMessage($person)]);
    }

    public function authorize(): void
    {
        $this->twig->display('authorize.twig');
    }

    public function checkAuthorization(): void
    {
        $request = $_POST['personal_code'];
        if (is_null($this->service->searchPersons('personal_code', $request)->getOne($request))) {
            $this->twig->display('messages.twig', ['message' => $this->messages->notRegistered($request)]);
        } else {
            $person = $this->service->searchPersons('personal_code', $request)->getOne($request);
            $this->twig->display('messages.twig', ['message' => $this->messages->authorized($person)]);
        }
    }


}

