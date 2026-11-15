<?php

namespace App\Exception\Application;

class TeamNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
