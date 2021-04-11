<?php

namespace App\Controllers;

use App\Messages;
use App\Services\Persons\PersonLoginService;
use App\Services\Persons\StorePersonRequest;
use App\Services\Persons\PersonService;
use InvalidArgumentException;
use Twig\Environment;

class PersonController
{
    private PersonService $personService;
    private PersonLoginService $personLoginService;
    private Environment $twig;
    private Messages $messages;

    public function __construct(PersonService $personService, PersonLoginService $personLoginService, Environment $twig)
    {
        $this->personService = $personService;
        $this->personLoginService = $personLoginService;
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
                    $this->personService->addPerson($person);
                    $this->twig->display('Messages.twig', ['message' => $this->messages->registerMessage($person)]);
                }
            } catch (InvalidArgumentException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function search(): void
    {
        $mysqlKey = key($_POST);
        $foundedPersons = ($this->personService->searchPersons($mysqlKey, $_POST[$mysqlKey]))->getAll();
        if (empty($foundedPersons)) {
            $this->twig->display('Messages.twig', ['message' => $this->messages->notFoundMessage($mysqlKey, $_POST[$mysqlKey])]);
        } else {
            $this->twig->display('PersonsInfoView.twig', ['persons' => $foundedPersons]);
        }
    }


    public function delete(): void
    {
        $request = $_POST['delete'];
        $person = $this->personService->searchPersons('personal_code', $request)->getOne($request);
        $this->personService->deletePerson($person);
        $this->twig->display('Messages.twig', ['message' => $this->messages->deleteMessage($person)]);
    }


    public function updateForm(): void
    {
        $request = $_POST['update'];
        $person = $this->personService->searchPersons('personal_code', $request)->getOne($request);
        $this->twig->display('UpdateInfoView.twig', ['person' => $person]);
    }


    public function update(): void
    {
        $request = $_POST['update'];
        $person = $this->personService->searchPersons('personal_code', $request)->getOne($request);
        $this->personService->updatePersonsInformation($person, $_POST['description']);
        $this->twig->display('Messages.twig', ['message' => $this->messages->updateMessage($person)]);
    }


    public function authorize(): void
    {
        if (isset ($_POST['login'])) {
            $request = $_POST['personal_code'];
            $person = $this->personLoginService->checkIfRegistered($request);
            if (is_null($person)) {
                $message = $this->messages->notRegistered($request);
            } else {
                $identifier = $person->getPersonalCode();
                $otp = $this->personLoginService->createOTP($identifier);
                $this->personLoginService->storeOTP($otp, $identifier);
                $link = $this->personLoginService->createOTPlink($identifier);
                $_SESSION['name'] = $person->getName();
                $_SESSION['otp'] = $otp->getToken();
            }
        }
        if($_SERVER["REQUEST_METHOD"] != "POST" && isset($_SESSION['name']))
        {
            $message = $this->messages->notValidOTP();
            unset($_SESSION['name']);
        }
        $this->twig->display('AuthorizationFormView.twig', ['link' => $link, 'message' => $message]);
    }


    public function secret(): void
    {
        if (isset($_SESSION['otp'])) {
            $request = $_SESSION['otp'];
            $name = $_SESSION['name'];
            if ($this->personLoginService->validateOTP($request)) {
                $this->twig->display('SecretPageView.twig', ['name' => $name]);
            } else {
                unset($_SESSION['otp']);
                header('Location:/authorize');
            }
        }
    }


    public function logout(): void
    {
        session_start();
        session_destroy();
        header('Location:/authorize');
    }

}
