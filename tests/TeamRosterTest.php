<?php

namespace App\Tests;

use App\Entity\TeamRoster;
use App\Tests\Mother\TeamRosterMother;
use PHPUnit\Framework\TestCase;

class TeamRosterTest extends TestCase
{
    public function testInstanceTeamRosterValidate()
    {
        $teamRoster = TeamRosterMother::create();

        $this->assertInstanceOf(TeamRoster::class, $teamRoster);
    }
}
