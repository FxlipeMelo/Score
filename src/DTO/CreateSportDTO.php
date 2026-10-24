<?php

namespace App\DTO;

use App\Enum\MatchType;
use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateSportDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $maxPlayerPerTeam,
        #[Assert\NotBlank]
        public MatchType $matchType
    )
    {
    }
}
