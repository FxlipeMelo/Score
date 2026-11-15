<?php

namespace App\Handler;

use App\DTO\EnrollTeamDTO;
use App\Entity\Championship;
use App\Entity\Registration;
use App\Exception\Application\TeamNotFoundException;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EnrollTeamHandler
{
    public function __construct(
        private readonly TeamRepository $teamRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
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
        $errors = $this->validator->validate($enrollTeam);

        if (count($errors) > 0) {
            throw new \DomainException("Validation failed" . $errors[0]->getMessage());
        }

        $this->entityManager->persist($enrollTeam);
        $this->entityManager->flush();

        return $enrollTeam;
    }
}
