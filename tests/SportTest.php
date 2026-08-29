<?php

namespace App\Tests;

use App\Entity\Sport;
use PHPUnit\Framework\TestCase;

class SportTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testCannotSetZeroOrNegativePlayers()
    {
        $sport = new Sport();

        $this->expectException(\InvalidArgumentException::class);

        $sport->setMaxPlayerPerTeam(0);
    }
}
