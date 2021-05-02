<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\User;

use App\Domain\Customer\Customer;
use App\Domain\Customer\CustomerNotFoundException;
use App\Infrastructure\Persistence\Customer\InMemoryCustomerRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new Customer(1, 'clint.eastwood', 'Clint', 'Eastwood');

        $userRepository = new InMemoryCustomerRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
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
        ];

        $userRepository = new InMemoryCustomerRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new Customer(1, 'obi-wan.kenobi@jedi.org', 'Obi-Wan', 'Kenobi');

        $userRepository = new InMemoryCustomerRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findCustomerById(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryCustomerRepository([]);
        $this->expectException(CustomerNotFoundException::class);
        $userRepository->findCustomerById(1);
    }
}
