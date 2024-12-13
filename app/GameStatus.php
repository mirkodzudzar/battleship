<?php

namespace App;

enum GameStatus: string
{
    case RESERVED = 'reserved';
    case IN_PROGRESS = 'in_progress';
    case CANCELED = 'canceled';
    case FINISHED = 'finished';
}
