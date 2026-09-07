<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $dateCreated;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Sport $sport;

    public function __construct(string $name, Sport $sport)
    {
        $this->name = $name;
        $this->dateCreated = new \DateTimeImmutable();
        $this->sport = $sport;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDateCreated(): \DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function getSport(): Sport
    {
        return $this->sport;
    }
}
