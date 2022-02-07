<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_CORRECT = 'Correct';
    const STATUS_INCORRECT = 'Incorrect';
    const STATUS_NOT_ANSWERED = 'Not Answered';
}
