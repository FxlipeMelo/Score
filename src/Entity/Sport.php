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
    private string $name;

    #[ORM\Column]
    private int $maxPlayerPerTeam;

    #[ORM\Column(length: 255 ,enumType: MatchType::class)]
    private MatchType $matchType;

    public function __construct(string $name, int $maxPlayerPerTeam, MatchType $matchType)
    {
        $this->name = $name;
        $this->maxPlayerPerTeam = $this->assertMaxPlayerPerTeam($maxPlayerPerTeam);
        $this->matchType = $matchType;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxPlayerPerTeam(): int
    {
        return $this->maxPlayerPerTeam;
    }

    private function assertMaxPlayerPerTeam(int $maxPlayerPerTeam): int //mudei de static para int o retorno da função
    {
        if ($maxPlayerPerTeam <= 0) {
            throw new \InvalidArgumentException("The maximum number of players per team must be a positive integer.");
        }

        return $this->maxPlayerPerTeam = $maxPlayerPerTeam;

//        return $this;
    }

    public function getMatchType(): MatchType
    {
        return $this->matchType;
    }

}
