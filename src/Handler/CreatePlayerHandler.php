<?php

namespace App\Handler;

use App\DTO\CreatePlayerDTO;
use App\Entity\Player;
use App\ValueObject\Cpf;
use Doctrine\ORM\EntityManagerInterface;

class CreatePlayerHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreatePlayerDTO $createPlayerDTO): Player
    {
        $cpf = new Cpf($createPlayerDTO->cpf);


        try {
            $player = new Player($createPlayerDTO->name, $createPlayerDTO->birthDate, $createPlayerDTO->height, $cpf);
            $this->entityManager->persist($player);
            $this->entityManager->flush();
        } catch (\InvalidArgumentException $e) {
            throw new \DomainException($e->getMessage());
        }

        return $player;
    }
}
