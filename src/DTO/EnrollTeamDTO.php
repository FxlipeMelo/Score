<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EnrollTeamDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $teamId,
    )
    {
    }
}
