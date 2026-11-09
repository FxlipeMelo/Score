<?php

namespace App\Handler;

use App\DTO\TeamRosterDTO;
use App\Entity\Team;
use App\Entity\TeamRoster;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class TeamRosterHandler
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function __invoke(TeamRosterDTO $teamRosterDTO, Team $team): TeamRoster
    {
        $player = $this->playerRepository->find($teamRosterDTO->playerID);

        if ($player === null) {
            throw new \InvalidArgumentException("Player not found");
        }

        $teamRoster = new TeamRoster($teamRosterDTO->shirtNumber, $team, $player);
        $this->entityManager->persist($teamRoster);

        $team->addTeamRoster($teamRoster);
        $this->entityManager->flush();

        return $teamRoster;
    }
}
