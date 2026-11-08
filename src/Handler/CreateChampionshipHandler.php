<?php

namespace App\Handler;

use App\DTO\CreateChampionshipDTO;
use App\Entity\Championship;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateChampionshipHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SportRepository $sportRepository
    )
    {
    }

    public function __invoke(CreateChampionshipDTO $createChampionshipDTO): Championship
    {
        $sport = $this->sportRepository->find($createChampionshipDTO->sportId);

        if ($sport === null) {
            throw new \InvalidArgumentException("Sport $createChampionshipDTO->sportId does not exist");
        }

        try {
            $championship = new Championship($createChampionshipDTO->name, $createChampionshipDTO->dateStart, $createChampionshipDTO->dateEnd, $sport);
            $this->entityManager->persist($championship);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $e) {
            throw new \DomainException($e->getMessage());
        }

        return $championship;
    }
}
