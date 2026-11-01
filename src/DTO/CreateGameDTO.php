<?php

namespace App\DTO;

use App\Entity\Registration;
use Symfony\Component\Validator\Constraints as Assert;
readonly class CreateGameDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Positive]
        public int $homeRegistrationId,
        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Assert\NotIdenticalTo(propertyPath: 'homeRegistrationId')]
        public int $awayRegistrationId,
        #[Assert\NotBlank]
        public \DateTimeImmutable $dateGame,
    )
    {
    }
}
