<?php

namespace App\Controller;

use App\DTO\EnrollTeamDTO;
use App\Entity\Championship;
use App\Handler\EnrollTeamHandler;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class RegistrationController extends AbstractController
{
    public function __construct(private readonly EnrollTeamHandler $enrollTeamHandler)
    {
    }

    #[Route('/championships/{championship}/registrations', name: 'app_championship_registrations', methods: ['POST'])]
    #[OA\Response(response: 201, description: 'Successful')]
    #[OA\Response(response: 404, description: 'Championship not found')]
    #[OA\Response(response: 422, description: 'Validation error for the provided data or this team is already registered for this championship.')]
    public function registration(Championship $championship, #[MapRequestPayload] EnrollTeamDTO $enrollTeamDTO): JsonResponse
    {
        try {
            $enrollTeam = ($this->enrollTeamHandler)($enrollTeamDTO, $championship);

            return new JsonResponse(['message' => 'Registration successful', 'registration' => $enrollTeam->getId()], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
