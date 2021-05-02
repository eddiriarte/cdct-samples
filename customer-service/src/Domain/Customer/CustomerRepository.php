<?php
declare(strict_types=1);

namespace App\Domain\Customer;

interface CustomerRepository
{
    /**
     * @return Customer[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function findCustomerById(int $id): Customer;

    /**
     * @param string $username
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function findCustomerByUsername(string $username): Customer;
}
