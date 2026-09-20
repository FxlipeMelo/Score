<?php

namespace App\Controller;

use App\DTO\CreateTeamDTO;
use App\Entity\Team;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class TeamController extends AbstractController
{
    public function __construct(private readonly SportRepository $sportRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/teams', name: 'app_teams', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateTeamDTO $createTeamDTO): JsonResponse
    {
        $sport = $this->sportRepository->find($createTeamDTO->sportId);

        if ($sport === null) {
            throw new NotFoundHttpException('Sport could not be found.');
        }

        $team = new Team($createTeamDTO->name, $sport);
        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Create Team', 'team' => $team->getId()], JsonResponse::HTTP_CREATED);
    }
}
