<?php

namespace App\Tests\ValueObject;

use App\Exception\Domain\InvalidCpfException;
use App\ValueObject\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    public function testCannotInstantiateWithInvalidCpf():void
    {
        $this->expectException(InvalidCpfException::class);
        $this->expectExceptionMessageIs("Invalid 111.111.111-11 CPF");

        $cpf = new Cpf('111.111.111-11');
    }

    public function testInstantiateWithValidCpf():void
    {
        $cpf = new Cpf('217.965.600-90');

        $this->assertInstanceOf(Cpf::class, $cpf);
    }

}
