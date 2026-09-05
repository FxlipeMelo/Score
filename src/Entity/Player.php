<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use App\Type\CpfType;
use App\ValueObject\Cpf;
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
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $birthDate = null;

    #[ORM\Column]
    private ?float $height = null;

    #[ORM\Column(type: 'cpf_type', length: 14)]
    private Cpf $cpf;

    public function __construct(Cpf $cpf)
    {
        $this->cpf = $cpf;
    }

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

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getCpf(): ?Cpf
    {
        return $this->cpf;
    }

    public function setCpf(Cpf $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }
}
