<?php

namespace App\Tests\Entity;

use App\Entity\Game;
use App\Exception\Domain\HomeAndAwayRegistrationTheSameException;
use App\Exception\Domain\TeamsRegisteredDifferentChampionshipException;
use App\Tests\Mother\ChampionshipMother;
use App\Tests\Mother\GameMother;
use App\Tests\Mother\RegistrationMother;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testAwayRegistrationCannotBeRegisteredInADifferentChampionshipThanHomeRegistration(): void
    {
        $championship1 = ChampionshipMother::create();
        $championship2 = ChampionshipMother::create();
        $homeRegistration = RegistrationMother::create(championship: $championship1);
        $awayRegistration = RegistrationMother::create(championship: $championship2);

        $this->expectException(TeamsRegisteredDifferentChampionshipException::class);

        GameMother::create(homeRegistration: $homeRegistration, awayRegistration: $awayRegistration);
    }

    public function testAwayRegistrationAndTheHomeRegistrationCannotBeTheSame(): void
    {
        $registration = RegistrationMother::create();

        $this->expectException(HomeAndAwayRegistrationTheSameException::class);

        GameMother::create(homeRegistration: $registration, awayRegistration: $registration);
    }

    public function testInstanceGameValidate(): void
    {
        $championship = ChampionshipMother::create();
        $homeRegistration = RegistrationMother::create(championship: $championship);
        $awayRegistration = RegistrationMother::create(championship: $championship);

        $game = GameMother::create(homeRegistration: $homeRegistration, awayRegistration: $awayRegistration);

        $this->assertSame($homeRegistration, $game->getHomeRegistration());
        $this->assertSame($championship, $game->getAwayRegistration()->getChampionship());
    }
}
