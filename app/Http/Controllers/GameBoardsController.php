<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class GameBoardsController extends Controller
{
    public function index()
    {
        return Inertia::render('Board');
    }
}
