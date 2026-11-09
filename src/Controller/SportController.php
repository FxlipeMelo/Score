<?php

namespace App\Controller;

use App\DTO\CreateSportDTO;
use App\Entity\Sport;
use App\Handler\CreateSportHandler;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class SportController extends AbstractController
{
    public function __construct(private readonly CreateSportHandler $createSportHandler)
    {
    }

    #[Route('/sports', name: 'app_sports', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Sport Add')]
    #[OA\Response(response: 409, description: 'One sport cannot be identified with another sport. ')]
    #[OA\Response(response: 422, description: 'Validation error for the provided data')]
    public function create(#[MapRequestPayload] CreateSportDTO $createSportDTO): JsonResponse
    {
        try {
            $sport = ($this->createSportHandler)($createSportDTO);

            return new JsonResponse(['message' => 'Sport created', 'sport' => $sport->getId()], JsonResponse::HTTP_CREATED);
        } catch (\RuntimeException $e) {
            return new JsonResponse(['message' => 'This sport already exists'], JsonResponse::HTTP_CONFLICT);
        }
    }
}
