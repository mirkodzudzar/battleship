<?php

namespace App\Models;

use App\GameStatus;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'status',
        'uuid'
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];
}
