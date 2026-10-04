<?php

namespace App\Controller;

use App\DTO\CreatePlayerDTO;
use App\Entity\Player;
use App\ValueObject\Cpf;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
class PlayerController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/players', name: 'app_players', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 422, description: 'The date of birth must be greater than six and cannot be a future date')]
    public function create(#[MapRequestPayload] CreatePlayerDTO $playerDTO): JsonResponse
    {
        $cpf = new Cpf($playerDTO->cpf);

        try {
            $player = new Player($playerDTO->name, $playerDTO->birthDate, $playerDTO->height, $cpf);
            $this->entityManager->persist($player);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse(['message' => 'Player created'], JsonResponse::HTTP_CREATED);
    }
}
