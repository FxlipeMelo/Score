<?php

namespace App\Exception\Domain;

class TwoPlayersSameShirtNumberException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
