<?php
namespace Tests;

use App\Models\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testFirstname(): void
    {
        $person = new Person('Mary', 'Smith', '125654-10054');
        $this->assertEquals('Mary', $person->getName());
    }
    public function testSurname(): void
    {
        $person = new Person('Mary', 'Smith', '125654-10054');
        $this->assertEquals('Smith', $person->getSurname());
    }
    public function testPersonalCode(): void
    {
        $person = new Person('Mary', 'Smith', '125654-10054');
        $this->assertEquals('125654-10054', $person->getPersonalCode());
    }

    public function testDescription(): void
    {
        $person = new Person('Mary', 'Smith', '125654-10054');
        $this->assertEquals('No information available', $person->getDescription());
    }

}