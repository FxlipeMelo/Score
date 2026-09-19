<?php

namespace App\Controller;

use App\DTO\CreateChampionshipDTO;
use App\Entity\Championship;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class ChampionshipController extends AbstractController
{
    public function __construct(private readonly SportRepository $sportRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/championships', name: 'app_championships', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateChampionshipDTO $championshipDTO): JsonResponse
    {
        $sport = $this->sportRepository->find($championshipDTO->sportId);

        if ($sport === null) {
            throw new NotFoundHttpException('Sport could not be found.');
        }

        $championship = new Championship($championshipDTO->name, $championshipDTO->dateStart, $championshipDTO->dateEnd, $sport);
        $this->entityManager->persist($championship);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Create Championship', 'championship' => $championship->getId()], JsonResponse::HTTP_CREATED);
    }
}
