<?php

namespace App\Enum;

enum ChampionshipStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'progress';
    case COMPLETED = 'completed';
}
