<?php
declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Route;

trait IsCompleted
{
    protected function isCompleted(): bool
    {
        return last(explode('/', Route::current()->uri())) === 'completed';
    }
}
