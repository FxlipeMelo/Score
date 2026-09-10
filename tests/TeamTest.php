<?php

namespace App\Tests;

use App\Entity\Team;
use App\Tests\Mother\TeamMother;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testInstanceTeamValidate()
    {
        $team = TeamMother::create();

        $this->assertInstanceOf(Team::class, $team);
    }
}
