<?php

namespace App\Models;

use App\GameStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'status',
        'uuid'
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(GameUser::class);
    }

    public function boards(): HasMany
    {
        return $this->hasMany(GameBoard::class);
    }

    public function moves(): HasMany
    {
        return $this->hasMany(GameMove::class);
    }
}
