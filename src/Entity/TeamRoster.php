<?php

namespace App\Entity;

use App\Repository\TeamRosterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRosterRepository::class)]
class TeamRoster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $shirtNumber;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $entryDate;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'teamRosters')]
    private Team $team;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'teamRoster')]
    private Player $player;

    public function __construct(int $shirtNumber, Team $team, Player $player)
    {
        $this->shirtNumber = $shirtNumber;
        $this->entryDate = new \DateTimeImmutable();
        $this->team = $team;
        $this->player = $player;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShirtNumber(): int
    {
        return $this->shirtNumber;
    }

    public function getEntryDate(): \DateTimeImmutable
    {
        return $this->entryDate;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
}
