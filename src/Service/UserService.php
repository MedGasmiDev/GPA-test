<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService
{
    private $userRepository;
    private $entityManager;
    private $validator;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data): User
    {
        
        if ($data['email'] !== $user->getEmail()) {
            $existingUser = $this->userRepository->findOneBy(['email' => $data['email']]);
            if ($data['email'] == null) {
                throw new BadRequestHttpException('email required');
            }
            if ($existingUser) {
                throw new BadRequestHttpException('Email is already in use.');
            }
        }

        if ($data['firstName'] == null) {
            throw new BadRequestHttpException('firstName required');
        }


        if ($data['lastName'] == null) {
            throw new BadRequestHttpException('lastName required');
        }

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);
        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setCreatedAt(new \DateTimeImmutable());

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string) $errors);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new \Exception('User not found');
        }

        if ($data['email'] !== $user->getEmail()) {
            $existingUser = $this->userRepository->findOneBy(['email' => $data['email']]);
            if ($data['email'] == null) {
                throw new BadRequestHttpException('email required');
            }
            if ($existingUser) {
                throw new BadRequestHttpException('Email is already in use.');
            }
        }

        if ($data['firstName'] == null) {
            throw new BadRequestHttpException('firstName required');
        }


        if ($data['lastName'] == null) {
            throw new BadRequestHttpException('lastName required');
        }

        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);
        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setUpdatedAt(new \DateTimeImmutable());

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string) $errors);
        }

        $this->entityManager->flush();

        return $user;
    }

    public function deleteUser(int $id): void
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new \Exception('User not found');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
