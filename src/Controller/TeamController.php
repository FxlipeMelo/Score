<?php

namespace App\Controller;

use App\DTO\CreateTeamDTO;
use App\Handler\CreateTeamHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class TeamController extends AbstractController
{
    public function __construct(private readonly CreateTeamHandler $createTeamHandler)
    {
    }

    #[Route('/teams', name: 'app_teams', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Team created successfully')]
    #[OA\Response(response: 404, description: 'Sport not found')]
    #[OA\Response(response: 422, description: 'Validation error for the provided data')]
    public function create(#[MapRequestPayload] CreateTeamDTO $createTeamDTO): JsonResponse
    {
        try {
            $team = ($this->createTeamHandler)($createTeamDTO);

            return new JsonResponse(['message' => 'Create Team', 'team' => $team->getId()], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }

    }
}
