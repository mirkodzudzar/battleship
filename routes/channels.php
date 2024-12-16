<?php

use App\Models\Game;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('games.{gameUuid}', function (string $guestToken, int $gameUuid) {
    $game = Game::where('uuid', $gameUuid)->first();
    return $game->users()->where('guest_token', $guestToken)->exists();
});
