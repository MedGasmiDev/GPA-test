<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetCollectionUsersController extends AbstractController
{
    public function __construct(private UserService $userService)
    {
    }

    #[Route('/api/users/', name: 'users', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return $this->json($users);
    }
}
