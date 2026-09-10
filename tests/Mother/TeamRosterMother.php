<?php

namespace App\Tests\Mother;

use App\Entity\Player;
use App\Entity\Team;
use App\Entity\TeamRoster;

class TeamRosterMother
{
    public static function create(
        int $shirtNumber = 10,
        ?Team $team = null,
        ?Player $player = null,
    ): TeamRoster
    {
        $team = $team ?? TeamMother::create();
        $player = $player ?? PlayerMother::create();
        return new TeamRoster($shirtNumber, $team, $player);
    }
}
