<?php


namespace App\Domain\Auth;


use App\Domain\DomainObjectBuilder;

class AuthenticatedUser
{
    use DomainObjectBuilder;

    private string $id;

    private string $username;

    private string $firstName;

    private string $lastName;

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
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
            'username' => $this->username,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
