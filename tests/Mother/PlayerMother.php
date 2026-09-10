<?php

namespace App\Tests\Mother;

use App\Entity\Player;
use App\ValueObject\Cpf;

class PlayerMother
{
    public static function create (
        string $name = 'Player Test',
        \DateTimeImmutable $birthDate = null,
        ?float $height = 1.75,
        ?Cpf $cpf = null
    ): Player
    {
        $birthDate = $birthDate ?? new \DateTimeImmutable('2005-01-01');
        $cpf = $cpf ?? new Cpf('217.965.600-90');
        return new Player($name, $birthDate, $height, $cpf);
    }
}
