<?php

namespace App\Controller;

use App\DTO\TeamRosterDTO;
use App\Entity\Team;
use App\Entity\TeamRoster;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class TeamRosterController extends AbstractController
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/teams/{team}/players', name: 'app_team_players', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Player Add')]
    #[OA\Response(response: 404, description: 'Player not found')]
    #[OA\Response(response: 409, description: 'Player already exists or two players with same shirt number')]
    public function addTeamRoster(#[MapRequestPayload] TeamRosterDTO $teamRosterDTO, Team $team): JsonResponse
    {
        $player = $this->playerRepository->find($teamRosterDTO->playerID);

        if ($player === null) {
            return new JsonResponse(['message' => 'Player not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $teamRoster = new TeamRoster($teamRosterDTO->shirtNumber, $team, $player);
        $this->entityManager->persist($teamRoster);

        try {
            $team->addTeamRoster($teamRoster);
            $this->entityManager->flush();
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_CONFLICT);
        }

        return new JsonResponse(['message' => 'Team roster added'], JsonResponse::HTTP_CREATED);
    }
}
