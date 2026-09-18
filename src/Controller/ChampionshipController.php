<?php

namespace App\Controller;

use App\DTO\CreateChampionshipDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1/score')]
final class ChampionshipController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/championships', name: 'app_championships', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateChampionshipDTO $championshipDTO): JsonResponse
    {
        return new JsonResponse(['message' => 'Endpoint works!']);
    }
}
