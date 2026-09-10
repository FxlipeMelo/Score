<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use App\ValueObject\Cpf;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $birthDate;

    #[ORM\Column]
    private float $height;

    #[ORM\Column(type: 'cpf_type', length: 14)]
    private Cpf $cpf;

    /**
     * @var Collection<int, TeamRoster>
     */
    #[ORM\OneToMany(targetEntity: TeamRoster::class, mappedBy: 'player')]
    private Collection $teamRosters;

    public function __construct(string $name, \DateTimeImmutable $birthDate, float $height, Cpf $cpf)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->height = $height;
        $this->cpf = $cpf;
        $this->teamRosters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getCpf(): Cpf
    {
        return $this->cpf;
    }
    public function getTeamRosters(): Collection
    {
        return $this->teamRosters;
    }

    public function addTeamRoster(TeamRoster $teamRoster): static
    {
        if (!$this->teamRosters->contains($teamRoster)) {
            $this->teamRosters->add($teamRoster);
        }

        return $this;
    }
}
