<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return Inertia::render('Board');
});

Route::get('/game/{game:uuid}', [GameController::class, 'show'])->name('game.show');
Route::post('/game', [GameController::class, 'store'])->name('game.store');
