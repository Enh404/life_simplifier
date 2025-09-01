<?php
declare(strict_types=1);

namespace App\Builders;

use App\Models\Event;
use App\Models\EventType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EventBuilder extends AbstractBuilder
{
    private ?Event $event = null;

    public function withObject(?Event $event = null): self
    {
        $this->event = $event;
        return $this;
    }

    public function withDataArray(array $data): self
    {
        $type = null;
        if (array_key_exists('type', $data) && !empty($data['type'])) {
            $type = EventType::where('code', $data['type']['code'])->first();
        }
        $activateAt = null;
        if (array_key_exists('activateAt', $data) && !empty($data['activateAt'])) {
            $activateAt = new \DateTimeImmutable($data['activateAt']);
        }

        $this->withName($this->getDataValue('name', $data))
            ->withUser($this->getDataValue('user', $data))
            ->withType($type)
            ->withActivateAt($activateAt);

        return $this;
    }

    private function withName(string $name): self
    {
        $this->set('name', $name);
        return $this;
    }

    private function withUser(User $user): self
    {
        $this->set('user_id', $user->id);
        return $this;
    }

    private function withType(EventType $type): self
    {
        $this->set('type_id', $type->id);
        return $this;
    }

    private function withActivateAt(?\DateTimeImmutable $activateAt): self
    {
        $this->set('activate_at', $activateAt);
        return $this;
    }

    public function build(): Event
    {
        if (empty($this->event)) {
            $this->event = new Event($this->data);
        } else {
            $this->event->name = $this->getDataValue('name');
            $this->event->type_id = $this->getDataValue('type_id');
            $this->event->activate_at = $this->getDataValue('activate_at');
        }

        return $this->event;
    }
}
