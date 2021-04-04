<?php

namespace App\Repositories\Persons;
use App\Models\Person;
use App\Models\PersonCollection;

interface PersonsRepository
{
    public function save(Person $person): void;
    public function delete(Person $person): void;
    public function get(string $key, string $parameter): PersonCollection;
    public function edit(Person $person, $request): void;
}


