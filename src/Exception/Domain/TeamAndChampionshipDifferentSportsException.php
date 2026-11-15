<?php

namespace App\Exception\Domain;

class TeamAndChampionshipDifferentSportsException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
