<?php

namespace App\Entity;

use App\Enum\MatchType;
use App\Enum\RegistrationStatus;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $payDate = null;

    #[ORM\Column(enumType: RegistrationStatus::class)]
    private RegistrationStatus $status;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private Team $team;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private Championship $championship;

    public function __construct(Team $team, Championship $championship)
    {
        $this->status = RegistrationStatus::PENDING;
        $this->team = $team;
        $this->championship = $championship;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayDate(): ?\DateTimeImmutable
    {
        return $this->payDate;
    }

    public function getStatus(): RegistrationStatus
    {
        return $this->status;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getChampionship(): Championship
    {
        return $this->championship;
    }

    public function payRegistration(): void
    {
        $this->payDate = new \DateTimeImmutable();
        $this->status = RegistrationStatus::COMPLETED;
    }
}
