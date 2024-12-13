<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class GameBoardController extends Controller
{
    public function index()
    {
        return Inertia::render('Board');
    }
}
