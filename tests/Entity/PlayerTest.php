<?php

namespace App\Tests\Entity;

use App\Entity\Player;
use App\Exception\Domain\InvalidBirthDateException;
use App\Tests\Mother\PlayerMother;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testInstancePlayerValidate()
    {
        $player = PlayerMother::create();

        $this->assertInstanceOf(Player::class, $player);
    }

    public function testThrowsExceptionWhenBirthDateIsInTheFuture()
    {
        $this->expectException(InvalidBirthDateException::class);
        $this->expectExceptionMessageIs('The date of birth must be greater than six and cannot be a future date.');

        $player = PlayerMother::create(birthDate: new \DateTimeImmutable('2030-05-01'));
    }

    public function testCannotCreatePlayerWithAgeUnderSix()
    {
        $this->expectException(InvalidBirthDateException::class);
        $this->expectExceptionMessageIs('The date of birth must be greater than six and cannot be a future date.');

        $player = PlayerMother::create(birthDate: new \DateTimeImmutable('2024-05-01'));
    }
}
