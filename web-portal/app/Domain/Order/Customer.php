<?php


namespace App\Domain\Order;


use App\Domain\DomainObjectBuilder;

class Customer
{
    use DomainObjectBuilder;

    private string $id;

    private string $firstName;

    private string $lastName;

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
