<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Builders\EventBuilder;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private function getEventBuilder(): EventBuilder
    {
        return new EventBuilder();
    }

    public function all(Request $request)
    {
        $user = $request->user();
        return Event::where('user_id', $user->id)->get();
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
        $user = $request->user();
        $type = EventType::where('code', $type)->first();

        return Event::where('user_id', $user->id)->where('type_id', $type->id)->get();
    }
}
