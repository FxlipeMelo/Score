<?php

namespace App\Exception\Domain;

class InvalidBirthDateException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
