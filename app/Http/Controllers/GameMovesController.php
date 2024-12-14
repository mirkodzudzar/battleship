<?php

namespace App\Http\Controllers;

use App\GameMoveStatus;
use App\Models\Game;
use Illuminate\Http\Request;

class GameMovesController extends Controller
{
    public function store(Game $game, Request $request)
    {
        // $validated = $request->validate([
        //     'move.x' => 'required|integer|min:1|max:10',
        //     'move.y' => 'required|integer|min:1|max:10',
        // ]);

        // $token = session('guest_token');

        // $move = $game->boards()
        //     ->where('guest_token', $token)
        //     ->where('x_value', $validated['move.x'])
        //     ->where('y_value', $validated['move.y'])
        //     ->first();

        // $game->moves()->create([
        //     'guest_token' => $token,
        //     'x_value' => $validated['move.x'],
        //     'y_value' => $validated['move.y'],
        //     'status' => $move ? GameMoveStatus::CORRECT : GameMoveStatus::INCORRECT,
        // ]);

        return response()->json(['status' => 'correct']);

        // return response()->json([
        //     'status' => $move ? 'correct' : 'incorrect',
        // ]);
    }
}
