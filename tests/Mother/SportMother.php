<?php

namespace App\Tests\Mother;

use App\Entity\Sport;
use App\Enum\MatchType;

class SportMother
{
    public static function create(
        string $name = 'Sport Teste',
        int $maxPlayerPerTeam = 11,
        MatchType $matchType = MatchType::TIME
    ): Sport
    {
        return new Sport($name, $maxPlayerPerTeam, $matchType);
    }
}
