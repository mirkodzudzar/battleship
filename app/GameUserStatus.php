<?php

namespace App;

enum GameUserStatus: string
{
    case WAITING = "waiting";
    case IN_GAME = "in_game";
    case FINISHED = "finished";
}
