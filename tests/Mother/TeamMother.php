<?php

namespace App\Tests\Mother;

use App\Entity\Sport;
use App\Entity\Team;

class TeamMother
{
    public static function create (
        string $name = 'Team Test',
        ?Sport $sport = null,
    ): Team
    {
        $sport = $sport ?? SportMother::create();
        return new Team($name, $sport);
    }
}
