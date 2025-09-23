<?php
declare(strict_types=1);

namespace App\Models;

enum Repeat: string
{
    case YEARLY = 'yearly';

    case MONTHLY = 'monthly';

    case WEEKLY = 'weekly';

    case DAILY = 'daily';
}
