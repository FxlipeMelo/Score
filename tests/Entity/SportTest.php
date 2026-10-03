<?php

namespace App\Tests\Entity;

use App\Tests\Mother\SportMother;
use PHPUnit\Framework\TestCase;

class SportTest extends TestCase
{
    public function testCannotSetZeroOrNegativePlayers()
    {
        $this->expectException(\InvalidArgumentException::class);

        $sport = SportMother::create(maxPlayerPerTeam: 0);
    }
}
