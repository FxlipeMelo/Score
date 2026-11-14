<?php

namespace App\Exception\Domain;

class InvalidMaxPlayerPerTeamException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
