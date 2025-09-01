<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'code' => 'holiday',
                'name' => 'Праздник'
            ],
            [
                'code' => 'birthday',
                'name' => 'День рождения'
            ],
            [
                'code' => 'job',
                'name' => 'Работа'
            ],
            [
                'code' => 'default',
                'name' => 'Без типа'
            ]
        ];

        foreach ($values as $value) {
            (new EventType($value))->save();
        }
    }
}
