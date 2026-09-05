<?php

namespace App\Tests\ValueObject;

use App\ValueObject\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    public function testCannotInstantiateWithInvalidCpf():void
    {
        $this->expectException(\InvalidArgumentException::class);

        $cpf = new Cpf('123');
    }

    public function testInstantiateWithValidCpf():void
    {
        $cpf = new Cpf('217.965.600-90');

        $this->assertInstanceOf(Cpf::class, $cpf);
    }

}
