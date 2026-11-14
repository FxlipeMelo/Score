<?php

namespace App\Exception\Domain;

class InvalidCpfException extends \DomainException
{
    public function __construct(String $message)
    {
        parent::__construct($message);
    }
}
