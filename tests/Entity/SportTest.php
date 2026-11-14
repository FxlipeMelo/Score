<?php

namespace App\Tests\Entity;

use App\Exception\Domain\InvalidMaxPlayerPerTeamException;
use App\Tests\Mother\SportMother;
use PHPUnit\Framework\TestCase;

class SportTest extends TestCase
{
    public function testCannotSetZeroOrNegativePlayers()
    {
        $this->expectException(InvalidMaxPlayerPerTeamException::class);

        $sport = SportMother::create(maxPlayerPerTeam: 0);
    }
}
