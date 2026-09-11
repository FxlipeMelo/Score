<?php

namespace App\Tests\Mother;

use App\Entity\Championship;
use App\Entity\Sport;
use App\Enum\ChampionshipStatus;

class ChampionshipMother
{
    public static function create(
        string $name = 'Championship Test',
        \DateTimeImmutable $dateStart = null,
        \DateTimeImmutable $dateEnd = null,
        Sport $sport = null,
    ): Championship
    {
        $dateStart = $dateStart ?? new \DateTimeImmutable('2026-06-03');
        $dateEnd = $dateEnd ?? new \DateTimeImmutable('2026-06-30');
        $sport = $sport ?? SportMother::create();
        return new Championship($name, $dateStart, $dateEnd, $sport);
    }
}
