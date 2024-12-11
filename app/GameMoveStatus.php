<?php

namespace App;

enum GameMoveStatus: string
{
    case CORRECT = 'correct';
    case INCORRECT = 'incorrect';
    case EMPTY = 'empty';

}
