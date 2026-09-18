<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateChampionshipDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        public string $name,
        #[Assert\NotBlank]
        public \DateTimeImmutable $dateStart,
        #[Assert\NotBlank]
        public \DateTimeImmutable $dateEnd,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $sportId
    )
    {
    }
}
