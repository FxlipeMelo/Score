<?php

namespace App\Controller;

use App\DTO\EnrollTeamDTO;
use App\Entity\Championship;
use App\Repository\ChampionshipRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class RegistrationController extends AbstractController
{
    public function __construct(private readonly TeamRepository $teamRepository,
                                private readonly EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/championships/{championship}/registrations', name: 'app_championship_registrations', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 400, description: 'Bad Request')]
    #[OA\Response(response: 404, description: 'Championship not found')]
    public function registration(Championship $championship, #[MapRequestPayload] EnrollTeamDTO $enrollTeamDTO): JsonResponse
    {
        $team = $this->teamRepository->find($enrollTeamDTO->teamId);

        if ($team === null) {
            throw new NotFoundHttpException('Team could not be found.');
        }

        try {
            $enrollTeam = $championship->enrollTeam($team);
            $this->entityManager->persist($enrollTeam);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['message' => 'Registration successful', 'championship' => $championship->getId()], JsonResponse::HTTP_CREATED);

    }
}
