<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Customer;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerNotFoundException;
use App\Domain\Customer\CustomerRepository;

class InMemoryCustomerRepository implements CustomerRepository
{
    /**
     * @var Customer[]
     */
    private $customers;

    /**
     * InMemoryCustomerRepository constructor.
     *
     * @param array|null $customers
     */
    public function __construct(array $customers = null)
    {
        $this->customers = $customers ?? [
                1 => new Customer(1, 'obi-wan.kenobi@jedi.org', 'Obi-Wan', 'Kenobi'),
                2 => new Customer(2, 'padme.amidala@naboo.com', 'Padme', 'Amidala'),
                3 => new Customer(3, 'kylo.ren@first-order.gov', 'Kylo', 'Ren'),
                4 => new Customer(4, 'mace.wimdu@jedi.org', 'Mace', 'Wimdu'),
                5 => new Customer(5, 'rey3000@scrum.tt', 'Rey', ''),
                6 => new Customer(6, 'han.solo@rebells.net', 'Matt', 'Damon'),
                7 => new Customer(7, 'jar-jar.binks@naboo.com', 'Jar Jar', 'Binks'),
                8 => new Customer(8, 'anakin.skywalker@jedi.org', 'Ananik', 'Skywalker'),
                9 => new Customer(9, 'boba.fett@mercenary.biz', 'Boba', 'Fett'),
                10 => new Customer(10, 'darth.maul@sith.net', 'Darth', 'Maul'),
                11 => new Customer(11, 'darth.vader@empire.gov', 'Darth', 'Vader'),
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->customers);
    }

    /**
     * {@inheritdoc}
     */
    public function findCustomerById(int $id): Customer
    {
        if (!isset($this->customers[$id])) {
            throw new CustomerNotFoundException();
        }

        return $this->customers[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function findCustomerByUsername(string $username): Customer
    {
        /** @var Customer $customer */
        foreach ($this->customers as $customer) {
            if ($customer->getUsername() !== $username)
                continue;

            return $customer;
        }

        throw new CustomerNotFoundException();
    }
}
