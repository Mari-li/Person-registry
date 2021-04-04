<?php

namespace App;
use App\Models\Person;


class Messages
{
    private string $message = '';

    public function deleteMessage(Person $person): void
    {
        echo $this->message= 'Person ' .$person->getName(). ' '. $person->getSurname() . ' is deleted from Person Registry';
    }

    public function notFoundMessage ($parameter, $value): void
    {
        echo $this->message= 'Person with ' .$parameter. ' '. $value . ' is not found in Registry';
    }

    public function registerMessage ($person): void
    {
        echo $this->message= 'Person ' .$person->getName(). ' '. $person->getSurname(). ' is successfully registered';
    }

    public function updateMessage ( $person): void
    {
        echo $this->message = 'Information of ' . $person->getName() . ' ' . $person->getSurname(). ' is successfully updated';
    }

}