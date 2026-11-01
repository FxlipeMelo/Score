<?php

namespace App\Controller;

use App\DTO\CreateGameDTO;
use App\Entity\Game;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class GameController extends AbstractController
{
    public function __construct(
        private readonly RegistrationRepository $registrationRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/games', name: 'app_games', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Games Created')]
    #[OA\Response(response: 404, description: 'Registration home or away not found')]
    #[OA\Response(response: 422, description: 'Validation error for the provided data or the home team is registered in a different championship than the away team')]
    public function create(#[MapRequestPayload] CreateGameDTO $createGameDTO): JsonResponse
    {
        $registrationHome = $this->registrationRepository->find($createGameDTO->homeRegistrationId);
        $registrationAway = $this->registrationRepository->find($createGameDTO->awayRegistrationId);

        if ($registrationHome === null || $registrationAway === null) {
            throw new NotFoundHttpException('Registration home or away not found');
        }

        if ($registrationHome->getChampionship() !== $registrationAway->getChampionship()) {
            throw new UnprocessableEntityHttpException('The home team is registered in a different championship than the away team.');
        }

        $game = new Game($createGameDTO->dateGame, $registrationHome, $registrationAway);
        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Game created successfully', 'game' => $game->getId()], JsonResponse::HTTP_CREATED);
    }
}
