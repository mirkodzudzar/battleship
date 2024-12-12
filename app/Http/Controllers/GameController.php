<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;
use App\Actions\CreateGame;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GameController extends Controller
{
    public function show(Game $game)
    {
        $guestToken = session('guest_token');

        $yourGrid = $game->boards()
            ->select(['x_value as x', 'y_value as y'])
            ->where('guest_token', $guestToken)
            ->get()
            ->map(fn($board) => ['x' => $board->x, 'y' => $board->y])
            ->toArray();

        return Inertia::render('Game', ['yourGrid' => $yourGrid ?: []]);
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

        return redirect()->route('game.show', ['game' => $game->uuid]);
    }
}
