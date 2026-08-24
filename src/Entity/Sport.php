<?php

namespace App\Entity;

use App\Enum\MatchType;
use App\Repository\SportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $maxPlayerPerTeam = null;

    #[ORM\Column(length: 255 ,enumType: MatchType::class)]
    private ?MatchType $matchType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxPlayerPerTeam(): ?int
    {
        return $this->maxPlayerPerTeam;
    }

    public function setMaxPlayerPerTeam(int $maxPlayerPerTeam): static
    {
        $this->maxPlayerPerTeam = $maxPlayerPerTeam;

        return $this;
    }

    public function getMatchType(): ?MatchType
    {
        return $this->matchType;
    }

    public function setMatchType(MatchType $matchType): static
    {
        $this->matchType = $matchType;

        return $this;
    }
}
