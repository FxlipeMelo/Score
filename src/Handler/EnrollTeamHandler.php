<?php

namespace App\Handler;

use App\DTO\EnrollTeamDTO;
use App\Entity\Championship;
use App\Entity\Registration;
use App\Exception\Application\TeamNotFoundException;
use App\Exception\Domain\TeamIsRegisteredThisChampionshipException;
use App\Repository\TeamRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

class EnrollTeamHandler
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function __invoke(EnrollTeamDTO $enrollTeamDTO, Championship $championship): Registration
    {
        $team = $this->teamRepository->find($enrollTeamDTO->teamId);

        if ($team === null) {
            throw new TeamNotFoundException('Team could not be found.');
        }

        $enrollTeam = $championship->enrollTeam($team);

        try {
            $this->entityManager->persist($enrollTeam);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new TeamIsRegisteredThisChampionshipException('This team is already registered for this championship.');
        }

        return $enrollTeam;
    }
}
