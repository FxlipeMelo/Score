<?php

namespace App\Exception\Domain;

class TeamIsRegisteredThisChampionshipException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
