<?php

namespace App\Controller;

use App\DTO\TeamRosterDTO;
use App\Entity\Team;
use App\Handler\TeamRosterHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class TeamRosterController extends AbstractController
{
    public function __construct(private readonly TeamRosterHandler $teamRosterHandler)
    {
    }

    #[Route('/teams/{team}/players', name: 'app_team_players', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Player Add')]
    #[OA\Response(response: 404, description: 'Player not found')]
    #[OA\Response(response: 409, description: 'Player already exists or two players with same shirt number')]
    public function addTeamRoster(#[MapRequestPayload] TeamRosterDTO $teamRosterDTO, Team $team): JsonResponse
    {
        try {
            $teamRoster = ($this->teamRosterHandler)($teamRosterDTO, $team);

            return new JsonResponse(['message' => 'Team roster added', 'teamRoster' => $teamRoster->getId()], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }
    }
}
