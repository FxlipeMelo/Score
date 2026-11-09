<?php

namespace App\Handler;

use App\DTO\CreateTeamDTO;
use App\Entity\Team;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateTeamHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SportRepository $sportRepository,
    )
    {
    }

    public function __invoke(CreateTeamDTO $createTeamDTO): Team
    {
        $sport = $this->sportRepository->find($createTeamDTO->sportId);

        if ($sport === null) {
            throw new \InvalidArgumentException("Sport $createTeamDTO->sportId does not exist");
        }

        $team = new Team($createTeamDTO->name, $sport);
        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $team;
    }
}
