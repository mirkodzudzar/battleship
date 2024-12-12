<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    protected $fillable = ['guest_token', 'status', 'is_creator'];
}
