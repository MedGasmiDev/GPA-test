<?php

namespace App\ApiResource\User;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetUserController extends AbstractController
{
    public function __construct(private UserService $userService) {}
    
    #[Route('/api/user/{id}', name: 'user_by_id', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }
        return $this->json($user);
    }

    
}
