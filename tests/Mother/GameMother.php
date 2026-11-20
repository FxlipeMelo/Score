<?php

namespace App\Tests\Mother;

use App\Entity\Game;
use App\Entity\Registration;

class GameMother
{
    public static function create(
        ?\DateTimeImmutable $dateGame = null,
        ?Registration $homeRegistration = null,
        ?Registration $awayRegistration = null,
    ): Game
    {
        $championship = ChampionshipMother::create();
        $dateGame = $dateGame ?? new \DateTimeImmutable();
        $homeRegistration = $homeRegistration ?? RegistrationMother::create(championship: $awayRegistration?->getChampionship() ?? $championship);
        $awayRegistration = $awayRegistration ?? RegistrationMother::create(championship: $homeRegistration?->getChampionship() ?? $championship);
        return new Game($dateGame, $homeRegistration, $awayRegistration);
    }
}
