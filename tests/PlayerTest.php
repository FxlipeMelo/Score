<?php

namespace App\Tests;

use App\Entity\Player;
use App\Tests\Mother\PlayerMother;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testInstancePlayerValidate()
    {
        $player = PlayerMother::create();

        $this->assertInstanceOf(Player::class, $player);
    }
}
