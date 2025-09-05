<?php
declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/completed', [EventController::class, 'all']);
    Route::post('', [EventController::class, 'create']);
    Route::prefix('/{eventType:code}')->group(function () {
        Route::get('', [EventController::class, 'byType']);
        Route::get('/completed', [EventController::class, 'byType']);
    });
    Route::prefix('/{event:id}')->group(function () {
        Route::get('', [EventController::class, 'show']);
        Route::put('', [EventController::class, 'update']);
        Route::delete('', [EventController::class, 'delete']);
        Route::get('/statusChange', [EventController::class, 'statusChange']);
    });
});

Route::middleware(['auth:sanctum'])->prefix('/goal')->group(function () {
    Route::get('', [GoalController::class, 'all']);
    Route::get('/completed', [GoalController::class, 'all']);
    Route::post('', [GoalController::class, 'create']);
    Route::prefix('/{goal:id}')->group(function () {
        Route::get('', [GoalController::class, 'show']);
        Route::put('', [GoalController::class, 'update']);
        Route::delete('', [GoalController::class, 'delete']);
        Route::get('/statusChange', [GoalController::class, 'statusChange']);
    });
});

Route::middleware(['auth:sanctum'])->prefix('/profile')->group(function () {
    Route::get('', [ProfileController::class, 'show']);
    Route::put('', [ProfileController::class, 'update']);
});
