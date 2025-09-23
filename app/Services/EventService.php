<?php
declare(strict_types=1);

namespace App\Services;

use App\Builders\EventBuilder;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Repeat;
use App\Models\User;

class EventService
{
    private static function getEventBuilder(): EventBuilder
    {
        return new EventBuilder();
    }

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

    public static function statusChange(Event $event): Event
    {
        if (!empty($event->repeat) && $event->completed == 0) {
            $newEventData = [
                'name' => $event->name,
                'user' => $event->user,
                'type' => $event->type,
                'repeat' => $event->repeat,
                'activate_at' => self::generateDate($event->activate_at, Repeat::tryFrom($event->repeat))
            ];
            $newEvent = self::getEventBuilder()->withDataArray($newEventData)->build();
            $newEvent->save();
        }
        $event->completed = (int)!$event->completed;
        $event->save();

        return $event;
    }

    private static function generateDate(string $activateAt, Repeat $repeat): string
    {
        $newDate = null;
        $eventDate = new \DateTimeImmutable($activateAt);

        if ($repeat == Repeat::YEARLY) {
            $nowDate = (new \DateTimeImmutable())->modify('+1 year');
            $newDate = new \DateTimeImmutable(
                $nowDate->format('Y') . '-' . $eventDate->format('m-d H:i:s')
            );
        } elseif ($repeat == Repeat::MONTHLY) {
            $nowDate = (new \DateTimeImmutable())->modify('+1 month');
            $newDate = new \DateTimeImmutable($nowDate->format('Y-m') . '-' .
                $eventDate->format('d H:i:s')
            );
        } elseif ($repeat == Repeat::WEEKLY) {
            $nowDate = (new \DateTimeImmutable())->modify('+7 day');
            $newDate = new \DateTimeImmutable($nowDate->format('Y-m-d') . '-' .
                $eventDate->format('H:i:s')
            );
        } elseif ($repeat == Repeat::DAILY) {
            $nowDate = (new \DateTimeImmutable())->modify('+1 day');
            $newDate = new \DateTimeImmutable($nowDate->format('Y-m-d') . '-' .
                $eventDate->format('H:i:s')
            );
        }

        return $newDate->format('Y-m-d H:i:s');
    }
}
