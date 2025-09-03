<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use App\Models\EventType;
use App\Models\User;

class EventService
{
    public static function getEventsByParams(User $user, bool $completed, ?string $date, ?EventType $type = null)
    {
        $event = Event::where('user_id', $user->id)->where('completed', $completed);

        if (!empty($date)) {
            $event->where('activate_at', 'like', $date . '%');
        }

        if (!empty($type)) {
            $event->where('type_id', $type->id);
        }

        return $event->orderBy('activate_at')->get();
    }
}
