<?php

namespace App\Http\Controllers;

use App\GameStatus;
use App\Models\Game;
use Inertia\Inertia;
use App\GameMoveStatus;
use App\GameUserStatus;
use App\Actions\CreateGame;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GamesController extends Controller
{
    public function show(Game $game)
    {
        $guestToken = session('guest_token');

        $grid = $game->boards()
            ->select(['x_value as x', 'y_value as y'])
            ->where('guest_token', $guestToken)
            ->get()
            ->map(fn($board) => ['x' => $board->x, 'y' => $board->y])
            ->toArray();

        return Inertia::render('Game', [
            'gameUuid' => $game->uuid,
            'grid' => $grid,
            'statuses' => [
                'correct' => GameMoveStatus::CORRECT->value,
                'incorrect' => GameMoveStatus::INCORRECT->value,
            ],
        ]);
    }

    public function store(Request $request, CreateGame $creator): RedirectResponse
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'moves' => 'required|array',
            'moves.*.x' => 'required|integer|min:1|max:10',
            'moves.*.y' => 'required|integer|min:1|max:10',
        ]);

        $game = $creator->handle($validated);

        session(['guest_token' => $validated['token']]);

        return redirect()->route('games.show', ['game' => $game->uuid]);
    }

    public function cancel(Game $game)
    {
        $game->update(['status' => GameStatus::CANCELED]);

        $game->users->each(function ($gameUser) {
            $gameUser->update(['status' => GameUserStatus::FINISHED]);
        });

        return redirect()->route('games.boards.index');
    }
}
