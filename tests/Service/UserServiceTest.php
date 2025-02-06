<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private $userRepository;
    private $entityManager;
    private $validator;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->userService = new UserService($this->userRepository, $this->entityManager, $this->validator);
    }

    public function testGetAllUsers(): void
    {
        $user = new User();
        $user->setFirstName('Mohamed')
             ->setLastName('Gasmi')
             ->setEmail('test@example.com')
             ->setPhone('123456789');

        $this->userRepository->method('findAll')->willReturn([$user]);

        $users = $this->userService->getAllUsers();

        $this->assertCount(1, $users);
        $this->assertEquals('Mohamed', $users[0]->getFirstName());
    }

    public function testGetUserById(): void
    {
        $user = new User();
        $user->setFirstName('Mohamed')
            ->setLastName('Gasmi')
            ->setEmail('test@example.com')
            ->setPhone('123456789');

        $this->userRepository->method('find')->willReturn($user);

        $result = $this->userService->getUserById(1);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('Mohamed', $result->getFirstName());
    }

    public function testGetUserByIdNotFound(): void
    {
        $this->userRepository->method('find')->willReturn(null);

        $result = $this->userService->getUserById(1);

        $this->assertNull($result);
    }

    public function testCreateUser(): void
    {
        $data = [
            'firstName' => 'Mohamed',
            'lastName' => 'Gasmi',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'birthday' => '1990-01-01',
        ];

        $violations = new ConstraintViolationList();
        $this->validator->method('validate')->willReturn($violations);

        $user = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Mohamed', $user->getFirstName());
        $this->assertEquals('Gasmi', $user->getLastName());
        $this->assertEquals('test@example.com', $user->getEmail());
        $this->assertEquals('123456789', $user->getPhone());
        $this->assertEquals(new \DateTime('1990-01-01'), $user->getBirthday());
        $this->assertNotNull($user->getCreatedAt());
    }

    public function testUpdateUser(): void
    {
        $user = new User();
        $user->setFirstName('Mohamed')
            ->setLastName('Gasmi')
            ->setEmail('test@example.com')
            ->setPhone('123456789')
            ->setBirthday(new \DateTime('1990-01-01'));

        $data = [
            'firstName' => 'UpdatedFirstName',
            'lastName' => 'UpdatedLastName',
            'email' => 'updated@example.com',
            'phone' => '987654321',
            'birthday' => '2000-01-01',
        ];

        $this->userRepository->method('find')->willReturn($user);

        $violations = new ConstraintViolationList();
        $this->validator->method('validate')->willReturn($violations);

        $updatedUser = $this->userService->updateUser(1, $data);

        $this->assertEquals('UpdatedFirstName', $updatedUser->getFirstName());
        $this->assertEquals('UpdatedLastName', $updatedUser->getLastName());
        $this->assertEquals('updated@example.com', $updatedUser->getEmail());
        $this->assertEquals('987654321', $updatedUser->getPhone());
        $this->assertEquals(new \DateTime('2000-01-01'), $updatedUser->getBirthday());
        $this->assertNotNull($updatedUser->getUpdatedAt());
    }

    public function testDeleteUser(): void
    {
        $user = new User();
        $user->setFirstName('Mohamed')
            ->setLastName('Gasmi')
            ->setEmail('test@example.com')
            ->setPhone('123456789');

        $this->userRepository->method('find')->willReturn($user);

        $this->userService->deleteUser(1);

        $this->assertTrue(true); 
    }

    public function testCreateUserWithDuplicateEmail(): void
    {
        $data = [
            'firstName' => 'Mohamed',
            'lastName' => 'Gasmi',
            'email' => 'test@example.com',
            'phone' => '123456789',
            'birthday' => '1990-01-01',
        ];

        $existingUser = new User();
        $existingUser->setEmail('test@example.com');
        $this->userRepository->method('findOneBy')->willReturn($existingUser);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
        $this->expectExceptionMessage('Email is already in use.');

        $this->userService->createUser($data);
    }

    public function testUpdateUserWithDuplicateEmail(): void
    {
        $user = new User();
        $user->setFirstName('Mohamed')
            ->setLastName('Gasmi')
            ->setEmail('test@example.com')
            ->setPhone('123456789')
            ->setBirthday(new \DateTime('1990-01-01'));

        $data = [
            'firstName' => 'UpdatedFirstName',
            'lastName' => 'UpdatedLastName',
            'email' => 'duplicate@example.com', 
            'phone' => '987654321',
            'birthday' => '2000-01-01',
        ];

        $existingUser = new User();
        $existingUser->setEmail('duplicate@example.com');
        $this->userRepository->method('findOneBy')->willReturn($existingUser);

        $this->userRepository->method('find')->willReturn($user);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\BadRequestHttpException::class);
        $this->expectExceptionMessage('Email is already in use.');

        $this->userService->updateUser(1, $data);
    }
}