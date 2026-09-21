<?php

namespace App\Enum;

enum RegistrationStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
