<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMove extends Model
{
    protected $fillable = ['guest_token', 'x_value', 'y_value', 'status'];
}
