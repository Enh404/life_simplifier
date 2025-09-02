<?php
declare(strict_types=1);

namespace App\Builders;

use App\Models\Goal;
use App\Models\User;

class GoalBuilder extends AbstractBuilder
{
    private ?Goal $goal = null;

    public function withObject(?Goal $goal = null): self
    {
        $this->goal = $goal;
        return $this;
    }

    public function withDataArray(array $data): self
    {
        $this->withName($this->getDataValue('name', $data))
            ->withUser($this->getDataValue('user', $data));

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

    public function build(): Goal
    {
        if (empty($this->goal)) {
            $this->goal = new Goal($this->data);
        } else {
            $this->goal->name = $this->getDataValue('name');
        }

        return $this->goal;
    }
}
