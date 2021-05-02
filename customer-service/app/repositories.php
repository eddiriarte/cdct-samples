<?php
declare(strict_types=1);

use App\Domain\Customer\CustomerRepository;
use App\Infrastructure\Persistence\Customer\InMemoryCustomerRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our CustomerRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        CustomerRepository::class => \DI\autowire(InMemoryCustomerRepository::class),
    ]);
};
