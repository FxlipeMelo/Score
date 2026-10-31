<?php

namespace App\Tests\Mother;

use App\Entity\Championship;
use App\Entity\Registration;
use App\Entity\Team;

class RegistrationMother
{
    public static function create(
        Team $team = null,
        Championship $championship = null,
    ): Registration
    {
        $team = $team ?? TeamMother::create();
        $championship = $championship ?? ChampionshipMother::create();
        return new Registration($team, $championship);
    }
}
