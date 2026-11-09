<?php

namespace App\Handler;

use App\DTO\CreateSportDTO;
use App\Entity\Sport;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

class CreateSportHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateSportDTO $createSportDTO): Sport
    {
        $sport = new Sport($createSportDTO->name, $createSportDTO->maxPlayerPerTeam, $createSportDTO->matchType);

        try {
            $this->entityManager->persist($sport);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new \RuntimeException('Unique constraint violation: ' . $e->getMessage());
        }

        return $sport;
    }
}
