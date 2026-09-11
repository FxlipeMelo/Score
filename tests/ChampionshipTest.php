<?php

namespace App\Tests;

use App\Entity\Championship;
use App\Tests\Mother\ChampionshipMother;
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
}
