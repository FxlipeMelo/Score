<?php

namespace App\Entity;

use App\Exception\Domain\HomeAndAwayRegistrationTheSameException;
use App\Exception\Domain\TeamsRegisteredDifferentChampionshipException;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class )]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Registration::class, inversedBy: 'matches')]
    private Registration $homeRegistration;

    #[ORM\ManyToOne(targetEntity: Registration::class, inversedBy: 'matches')]
    private Registration $awayRegistration;

    #[ORM\Column]
    private \DateTimeImmutable $dateGame;

    public function __construct(\DateTimeImmutable $dateGame, Registration $homeRegistration, Registration $awayRegistration)
    {
        $this->assertHomeAndAwayRegistrationShouldBeDifferent($homeRegistration, $awayRegistration);
        $this->assertAwayRegistrationSameChampionshipThatHomeRegistration($homeRegistration, $awayRegistration);
        $this->dateGame = $dateGame;
        $this->homeRegistration = $homeRegistration;
        $this->awayRegistration = $awayRegistration;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Registration
     */
    public function getHomeRegistration(): Registration
    {
        return $this->homeRegistration;
    }

    /**
     * @return Registration
     */
    public function getAwayRegistration(): Registration
    {
        return $this->awayRegistration;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateGame(): \DateTimeImmutable
    {
        return $this->dateGame;
    }

    private function assertAwayRegistrationSameChampionshipThatHomeRegistration(Registration $homeRegistration, Registration $awayRegistration): void
    {
        if ($homeRegistration->getChampionship() !== $awayRegistration->getChampionship()) {
            throw new TeamsRegisteredDifferentChampionshipException('The home team is registered in a different championship than the away team.');
        }
    }

    private function assertHomeAndAwayRegistrationShouldBeDifferent(Registration $homeRegistration, Registration $awayRegistration): void
    {
        if ($homeRegistration->getTeam() === $awayRegistration->getTeam()) {
            throw new HomeAndAwayRegistrationTheSameException('The home team and away team are the same.');
        }
    }
}
