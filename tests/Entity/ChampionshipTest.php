<?php

namespace App\Tests\Entity;

use App\Entity\Championship;
use App\Entity\Registration;
use App\Enum\RegistrationStatus;
use App\Tests\Mother\ChampionshipMother;
use App\Tests\Mother\SportMother;
use App\Tests\Mother\TeamMother;
use PHPUnit\Framework\TestCase;

class ChampionshipTest extends TestCase
{
    public function testInstanceChampionshipValidate()
    {
        $championship = ChampionshipMother::create();

        $this->assertInstanceOf(Championship::class, $championship);
    }

    public function testFinishChampionshipBeforeStartDateThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $championship = ChampionshipMother::create(dateEnd: new \DateTimeImmutable('2025-05-01'));
    }

    public function testCannotEnrollTeamWithDifferentSport()
    {
        $sport1 = SportMother::create(name: 'Sport 1');
        $sport2 = SportMother::create(name: 'Sport 2');

        $team = TeamMother::create(sport: $sport1);
        $championship = ChampionshipMother::create(sport: $sport2);

        $this->expectException(\InvalidArgumentException::class);

        $championship->enrollTeam($team);
    }

    public function testCanEnrollTeamSuccessfully()
    {
        $sport1 = SportMother::create();

        $team = TeamMother::create(sport: $sport1);
        $championship = ChampionshipMother::create(sport: $sport1);

        $registration = $championship->enrollTeam($team);

        $this->assertInstanceOf(Registration::class, $registration);
        $this->assertEquals(RegistrationStatus::PENDING, $registration->getStatus());
    }
}
