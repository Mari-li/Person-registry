<?php

namespace App;

use App\Models\Person;


class Messages
{
    private string $message = '';

    public function deleteMessage(Person $person): string
    {
        return $this->message = 'Person ' . $person->getName() . ' ' . $person->getSurname() . ' is deleted from Person Registry';
    }

    public function notFoundMessage(string $parameter, string $value): string
    {
        return $this->message = 'Person with ' . $parameter . ' ' . $value . ' is not found in Registry';
    }

    public function registerMessage(Person $person): string
    {
        return $this->message = 'Person ' . $person->getName() . ' ' . $person->getSurname() . ' is successfully registered';
    }

    public function updateMessage(Person $person): string
    {
        return $this->message = 'Information of ' . $person->getName() . ' ' . $person->getSurname() . ' is successfully updated';
    }

    public function notRegistered(string $personalCode): string
    {
        return 'Person with personal code \'' . $personalCode . '\' is not registered in Person Registry';
    }

    public function authorized(Person $person): string
    {
        return $person->getName() .', activation code is sent to your e-mail';
    }

}