<?php

namespace App\Controller;

use App\DTO\CreateGameDTO;
use App\Handler\CreateGameHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class GameController extends AbstractController
{
    public function __construct(
        private readonly CreateGameHandler $createGameHandler
    )
    {
    }

    #[Route('/games', name: 'app_games', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Games Created')]
    #[OA\Response(response: 404, description: 'Registration home or away not found')]
    #[OA\Response(response: 422, description: 'Validation error for the provided data or the home team is registered in a different championship than the away team')]
    public function create(#[MapRequestPayload] CreateGameDTO $createGameDTO): JsonResponse
    {
        try {
            $game = ($this->createGameHandler)($createGameDTO);

            return new JsonResponse(['message' => 'Game created successfully', 'game' => $game->getId()], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
