<?php
declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->prefix('/event')->group(function () {
    Route::get('', [EventController::class, 'all']);
    Route::post('', [EventController::class, 'create']);
    Route::get('/{eventType:code}', [EventController::class, 'byType']);
    Route::prefix('/{event:id}')->group(function () {
        Route::get('', [EventController::class, 'show']);
        Route::put('', [EventController::class, 'update']);
        Route::delete('', [EventController::class, 'delete']);
    });
});
