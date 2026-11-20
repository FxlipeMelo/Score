<?php

namespace App\Handler;

use App\DTO\CreateGameDTO;
use App\Entity\Game;
use App\Exception\Application\RegistrationNotFoundException;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateGameHandler
{
    public function __construct(
        private readonly RegistrationRepository $registrationRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(CreateGameDTO $createGameDTO): Game
    {
        $registrationHome = $this->registrationRepository->find($createGameDTO->homeRegistrationId);
        $registrationAway = $this->registrationRepository->find($createGameDTO->awayRegistrationId);

        if ($registrationHome === null || $registrationAway === null) {
            throw new RegistrationNotFoundException('Registration home or away not found');
        }

        $game = new Game($createGameDTO->dateGame, $registrationHome, $registrationAway);
        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $game;
    }
}
