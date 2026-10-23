<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class TeamRosterDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Range(min: 1, max: 100)]
        public int $shirtNumber,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $playerID
    )
    {
    }
}
