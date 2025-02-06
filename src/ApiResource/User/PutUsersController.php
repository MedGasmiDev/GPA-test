<?php

declare(strict_types=1);

namespace App\ApiResource\User;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PutUsersController extends AbstractController
{
    public function __construct(private UserService $userService)
    {
    }

    #[Route('/api/user/{id}', name: 'update_user', methods: ['PUT'])]
    public function __invoke(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $user = $this->userService->updateUser($id, $data);

            return $this->json($user);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }
    }
}
