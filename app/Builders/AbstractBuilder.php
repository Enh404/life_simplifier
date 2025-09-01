<?php
declare(strict_types=1);

namespace App\Builders;

abstract class AbstractBuilder
{
    protected array $data = [];

    protected function getDataValue(string $key, ?array $data = null): mixed
    {
        $data = is_null($data)
            ? $this->data
            : $data;

        return array_key_exists($key, $data)
            ? $data[$key]
            : null;
    }

    protected function set(string $key, mixed $data): void
    {
        $this->data[$key] = $data;
    }

    public static function create(): static
    {
        return new static();
    }
}
