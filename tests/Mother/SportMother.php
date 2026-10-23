<?php

namespace App\Tests\Mother;

use App\Entity\Sport;
use App\Enum\MatchType;

class SportMother
{
    public static function create(
        string $name = null,
        int $maxPlayerPerTeam = 11,
        MatchType $matchType = MatchType::TIME
    ): Sport
    {
        $name = $name ?? uniqid('Sport_', true);
        return new Sport($name, $maxPlayerPerTeam, $matchType);
    }
}
