<?php

namespace App\Exception\Application;

class SportNotFoundException extends \InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
