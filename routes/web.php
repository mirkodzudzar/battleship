<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameBoardController;
use App\Http\Controllers\HomeController;

Route::get('/', HomeController::class)->name("home");

Route::get('/game/board', [GameBoardController::class, 'index'])->name('game.board.index');

Route::get('game/{game:uuid}', [GameController::class, 'show'])->name('game.show');
Route::post('game', [GameController::class, 'store'])->name('game.store');
Route::post('game/{game:uuid}/cancel', [GameController::class, 'cancel'])->name('game.cancel');
