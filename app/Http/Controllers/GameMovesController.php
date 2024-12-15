<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Actions\CreateGameMove;

class GameMovesController extends Controller
{
    public function store(Game $game, Request $request, CreateGameMove $creator)
    {
        $validated = $request->validate([
            'moves.x' => 'required|integer|min:1|max:10',
            'moves.y' => 'required|integer|min:1|max:10',
        ]);

        $token = session('guest_token');

        $move = $creator->handle($validated, $game, $token);

        return response()->json([
            'status' => $move->status,
        ]);
    }
}
