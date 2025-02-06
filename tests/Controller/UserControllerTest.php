<?php

declare(strict_types=1);
// tests/Controller/UserControllerTest.php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserCreation()
    {
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john.doe@example.com');
        $user->setPhone('0758062008');

        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('0758062008', $user->getPhone());
        $this->assertEquals('john.doe@example.com', $user->getEmail());
    }
}
