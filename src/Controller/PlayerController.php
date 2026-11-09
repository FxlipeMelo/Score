<?php

namespace App\Controller;

use App\DTO\CreatePlayerDTO;
use App\Handler\CreatePlayerHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
class PlayerController extends AbstractController
{
    public function __construct(private readonly CreatePlayerHandler $createPlayerHandler)
    {
    }

    #[Route('/players', name: 'app_players', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 422, description: 'The date of birth must be greater than six and cannot be a future date')]
    public function create(#[MapRequestPayload] CreatePlayerDTO $playerDTO): JsonResponse
    {
        try {
            $player = ($this->createPlayerHandler)($playerDTO);

            return new JsonResponse(['message' => 'Player created', 'player' => $player->getId()], JsonResponse::HTTP_CREATED);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

    }
}
