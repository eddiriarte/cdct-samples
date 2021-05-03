<?php
declare(strict_types=1);

namespace Tests\Domain\User;

use App\Domain\Customer\Customer;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'obi-wan.kenobi@jedi.org', 'Obi-Wan', 'Kenobi'],
            [2, 'padme.amidala@naboo.com', 'Padme', 'Amidala'],
            [3, 'kylo.ren@first-order.gov', 'Kylo', 'Ren'],
            [4, 'mace.wimdu@jedi.org', 'Mace', 'Wimdu'],
            [5, 'rey3000@scrum.tt', 'Rey', ''],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testGetters(int $id, string $username, string $firstName, string $lastName)
    {
        $user = new Customer($id, $username, $firstName, $lastName);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testJsonSerialize(int $id, string $username, string $firstName, string $lastName)
    {
        $user = new Customer($id, $username, $firstName, $lastName);

        $expectedPayload = json_encode([
            'id' => $id,
            'username' => $username,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $this->assertEquals($expectedPayload, json_encode($user));
    }
}
