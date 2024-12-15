<?php

namespace App\Actions;

use App\Models\Game;
use App\GameMoveStatus;
use App\Models\GameMove;
use Illuminate\Support\Facades\DB;

class CreateGameMove
{
    public function handle(array $validatedData, Game $game, string $token): GameMove
    {
        $move = DB::transaction(function () use ($validatedData, $game, $token): GameMove {
            $x = $validatedData['moves']['x'];
            $y = $validatedData['moves']['y'];

            $boardMove = $game->boards()
                ->whereNot('guest_token', $token)
                ->where('x_value', $x)
                ->where('y_value', $y)
                ->first();

            $move = $game->moves()->create([
                'guest_token' => $token,
                'x_value' => $x,
                'y_value' => $y,
                'status' => $boardMove ? GameMoveStatus::CORRECT : GameMoveStatus::INCORRECT,
            ]);

            return $move;
        });

        return $move;
    }
}
