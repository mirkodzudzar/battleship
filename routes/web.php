<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\GameMovesController;
use App\Http\Controllers\GameBoardsController;

Route::get('/', HomeController::class)->name("home");

Route::get('/games/boards', [GameBoardsController::class, 'index'])->name('games.boards.index');

Route::get('games/{game:uuid}', [GamesController::class, 'show'])->name('games.show');
Route::post('games', [GamesController::class, 'store'])->name('games.store');
Route::post('games/{game:uuid}/cancel', [GamesController::class, 'cancel'])->name('games.cancel');

Route::post('games/{game:uuid}/moves', [GameMovesController::class, 'store'])->name('games.moves.store');
