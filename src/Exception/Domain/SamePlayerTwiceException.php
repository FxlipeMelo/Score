<?php

namespace App\Exception\Domain;

class SamePlayerTwiceException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
