<?php

namespace App\ValueObject;

use App\Exception\Domain\InvalidCpfException;

class Cpf {

    private string $cpf;
    public function __construct(string $cpf)
    {
        if (!$this->validateCPF($cpf)) {
            throw new InvalidCpfException("Invalid $cpf CPF");
        }

        $this->cpf = $cpf;
    }

    private function validateCPF(string $cpf):bool
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        //method for calculating a CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return "{$this->cpf}";
    }
}
