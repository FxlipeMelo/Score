<?php

namespace App\Entity;

use App\Enum\ChampionshipStatus;
use App\Repository\ChampionshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChampionshipRepository::class)]
class Championship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $dateStart;

    #[ORM\Column]
    private \DateTimeImmutable $dateEnd;

    #[ORM\Column(enumType: ChampionshipStatus::class)]
    private ChampionshipStatus $status;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Sport $sport;

    /**
     * @var Collection<int, Registration>
     */
    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'championship')]
    private Collection $registrations;

    public function __construct(string $name, \DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd, Sport $sport)
    {
        $this->name = $name;
        $this->createdAt = new \DateTimeImmutable();
        $this->dateStart = $dateStart;
        $this->dateEnd = $this->assertDateStartLessThanDateEnd($dateStart, $dateEnd);
        $this->status = ChampionshipStatus::PENDING;
        $this->sport = $sport;
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDateStart(): \DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function getDateEnd(): \DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function getStatus(): ChampionshipStatus
    {
        return $this->status;
    }

    public function getSport(): Sport
    {
        return $this->sport;
    }

    public function startChampionship(): void
    {
        $this->status = ChampionshipStatus::IN_PROGRESS;
    }

    public function endChampionship(): void
    {
        $this->status = ChampionshipStatus::COMPLETED;
    }

    private function assertDateStartLessThanDateEnd(\DateTimeImmutable $dateStart, \DateTimeImmutable $dateEnd): \DateTimeImmutable
    {
        if ($dateStart < $dateEnd) {
            return $dateEnd;
        }

        throw new \InvalidArgumentException('Date start must be less than date end');
    }

    public function enrollTeam(Team $team): Registration
    {
        if ($this->sport !== $team->getSport()) {
            throw new \InvalidArgumentException('The team and the championship belong to different sports.');
        }

        $registration = new Registration($team, $this);
        $this->registrations->add($registration);

        return $registration;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

}
