<?php
declare(strict_types=1);

namespace App\Builders;

use App\Models\Profile;
use App\Models\User;

class ProfileBuilder extends AbstractBuilder
{
    private ?Profile $profile = null;

    public function withObject(?Profile $profile = null): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function withDataArray(array $data): self
    {
        $telegram = null;
        if (array_key_exists('telegram', $data) && !empty($data['telegram'])) {
            $telegram = 'https://t.me/' . $data['telegram'];
        }

        $this->withUser($this->getDataValue('user', $data))
            ->withBirthday($this->getDataValue('birthday', $data))
            ->withTelegram($telegram)
            ->withHeight($this->getDataValue('height', $data))
            ->withWeight($this->getDataValue('weight', $data));

        return $this;
    }

    private function withUser(User $user): self
    {
        $this->set('user_id', $user->id);
        return $this;
    }

    private function withBirthday(?string $birthday): self
    {
        $this->set('birthday', $birthday);
        return $this;
    }

    private function withTelegram(?string $telegram): self
    {
        $this->set('telegram', $telegram);
        return $this;
    }

    private function withHeight(?float $height): self
    {
        $this->set('height', $height);
        return $this;
    }

    private function withWeight(?float $weight): self
    {
        $this->set('weight', $weight);
        return $this;
    }

    public function build(): Profile
    {
        if (empty($this->profile)) {
            $this->profile = new Profile($this->data);
        } else {
            $this->profile->birthday = $this->getDataValue('birthday');
            $this->profile->telegram = $this->getDataValue('telegram');
            $this->profile->height = $this->getDataValue('height');
            $this->profile->weight = $this->getDataValue('weight');
        }

        return $this->profile;
    }
}
