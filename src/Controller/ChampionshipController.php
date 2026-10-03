<?php

namespace App\Controller;

use App\DTO\CreateChampionshipDTO;
use App\Entity\Championship;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
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
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 404, description: 'Sport not found')]
    #[OA\Response(response: 422, description: 'Date end before date start')]
    public function create(#[MapRequestPayload] CreateChampionshipDTO $championshipDTO): JsonResponse
    {
        $sport = $this->sportRepository->find($championshipDTO->sportId);

        if ($sport === null) {
            throw new NotFoundHttpException('Sport could not be found.');
        }

        try {
            $championship = new Championship($championshipDTO->name, $championshipDTO->dateStart, $championshipDTO->dateEnd, $sport);
            $this->entityManager->persist($championship);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse(['message' => 'Create Championship', 'championship' => $championship->getId()], JsonResponse::HTTP_CREATED);
    }
}
