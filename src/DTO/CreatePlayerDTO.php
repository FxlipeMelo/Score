<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreatePlayerDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\LessThan('-6 years')]
        public \DateTimeImmutable $birthDate,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public float $height,
        #[Assert\NotBlank]
        #[Assert\Length(min: 11, max: 14)]
        public string $cpf
    )
    {
    }
}
