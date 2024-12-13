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
            $game = Game::query()
                ->where('status', GameStatus::RESERVED)
                ->first();

            $guest = $game?->users()->where('guest_token', $validatedData['token'])->first();

            if ($game && !$guest) {
                $game->users()->create([
                    'guest_token' => $validatedData['token'],
                    'is_creator' => false,
                ]);

                $game->users->each(function ($gameUser) {
                    $gameUser->update(['status' => GameUserStatus::IN_GAME]);
                });

                $game->update(['status'=> GameStatus::IN_PROGRESS]);
            } else {
                $game = Game::create([
                    'uuid' => Str::uuid(),
                    'status' => GameStatus::RESERVED,
                ]);

                $game->users()->create([
                    'guest_token' => $validatedData['token'],
                    'status' => GameUserStatus::WAITING,
                    'is_creator' => true,
                ]);
            }

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
