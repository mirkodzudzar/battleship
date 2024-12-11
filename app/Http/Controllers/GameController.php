<?php

namespace App\Http\Controllers;

use App\GameStatus;
use App\Models\Game;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameController extends Controller
{
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            '*.x' => 'required|integer|min:1|max:10',
            '*.y' => 'required|integer|min:1|max:10',
        ]);

        $game = Game::create([
            'uuid' => Str::uuid(),
            'status' => GameStatus::RESERVED,
        ]);

        return response(['status' => 'ok'], 201);
    }
}
