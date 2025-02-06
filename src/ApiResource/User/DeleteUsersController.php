<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUsersController extends AbstractController
{
    public function __construct(private UserService $userService)
    {
    }

    #[Route('/api/user/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);

            return $this->json(['message' => 'User deleted']);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }
    }
}
