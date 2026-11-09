<?php

namespace App\Controller;

use App\DTO\CreateChampionshipDTO;
use App\Handler\CreateChampionshipHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class ChampionshipController extends AbstractController
{
    public function __construct(private readonly CreateChampionshipHandler $createChampionshipHandler)
    {
    }

    #[Route('/championships', name: 'app_championships', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 404, description: 'Sport not found')]
    #[OA\Response(response: 422, description: 'Date end before date start')]
    public function create(#[MapRequestPayload] CreateChampionshipDTO $createChampionshipDTO): JsonResponse
    {
        try {
            $championship = ($this->createChampionshipHandler)($createChampionshipDTO);

            return new JsonResponse(['message' => 'Create Championship', 'championship' => $championship->getId()], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
