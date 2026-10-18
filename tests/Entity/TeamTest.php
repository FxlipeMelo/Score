<?php

namespace App\Tests\Entity;

use App\Entity\Team;
use App\Tests\Mother\PlayerMother;
use App\Tests\Mother\TeamMother;
use App\Tests\Mother\TeamRosterMother;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase
{
    public function testInstanceTeamValidate()
    {
        $team = TeamMother::create();

        $this->assertInstanceOf(Team::class, $team);
    }

    public function testCannotAddTwoPlayersWithSameShirtNumber()
    {
        $this->expectException(\DomainException::class);

        $team = TeamMother::create();
        $player1 = PlayerMother::create(name: 'Player 1');
        $player2 = PlayerMother::create(name: 'Player 2');

        $teamRoster1 = TeamRosterMother::create(player: $player1, shirtNumber: 9);
        $teamRoster2 = TeamRosterMother::create(player: $player2, shirtNumber: 9);

        $team->addTeamRoster($teamRoster1);
        $team->addTeamRoster($teamRoster2);

    }
}
