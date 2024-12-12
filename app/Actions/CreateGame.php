<?php

namespace App\Actions;

use App\GameStatus;
use App\Models\Game;
use App\GameUserStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateGame
{
    public function handle(array $validatedData): Game
    {
        $game = DB::transaction(function () use ($validatedData): Game {
            $game = Game::create([
                'uuid' => Str::uuid(),
                'status' => GameStatus::RESERVED,
            ]);

            $game->users()->create([
                'guest_token' => $validatedData['token'],
                'status'=> GameUserStatus::WAITING,
                'is_creator' => true,
            ]);

            foreach ($validatedData['moves'] as $move) {
                $game->boards()->create([
                    'guest_token' => $validatedData['token'],
                    'x_value' => $move['x'],
                    'y_value' => $move['y'],
                ]);
            }

            return $game;
        });

        return $game;
    }
}
