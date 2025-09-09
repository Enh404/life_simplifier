<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\EventBuilder;
use App\Http\Controllers\Traits\IsCompleted;
use App\Models\Event;
use App\Models\EventType;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use IsCompleted;

    private function getEventService(): EventService
    {
        return new EventService();
    }

    private function getEventBuilder(): EventBuilder
    {
        return new EventBuilder();
    }

    public function all(Request $request)
    {
        $user = $request->user();
        return $this->getEventService()::getEventsByParams(
            user: $user,
            completed: $this->isCompleted(),
            date: $request->query('date')
        );
    }

    public function create(Request $request): Event
    {
        $data = $request->all();
        $data['user'] = $request->user();
        $event = $this->getEventBuilder()->withDataArray($data)->build();
        $event->save();

        return $event;
    }

    public function show(Event $event): Event
    {
        return $event;
    }

    public function update(Request $request, Event $event): Event
    {
        $data = $request->all();
        $data['user'] = $request->user();
        $event = $this->getEventBuilder()->withObject($event)->withDataArray($data)->build();
        $event->save();

        return $event;
    }

    public function delete(Event $event): array
    {
        $event->delete();
        return ['status' => true];
    }

    public function byType(Request $request, string $type)
    {
        $completed = $this->isCompleted();
        $user = $request->user();
        $type = EventType::where('code', $type)->first();

        return $this->getEventService()::getEventsByParams(
            user: $user,
            completed: $completed,
            date: $request->query('date'),
            type: $type
        );
    }

    public function statusChange(Event $event): Event
    {
        $event->completed = (int)!$event->completed;
        $event->save();

        return $event;
    }

    public function allTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return EventType::all();
    }
}
