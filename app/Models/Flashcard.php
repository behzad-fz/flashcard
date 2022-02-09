<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
    ];

    const STATUS_CORRECT = 'Correct';
    const STATUS_INCORRECT = 'Incorrect';
    const STATUS_NOT_ANSWERED = 'Not Answered';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function getAllWithCurrentUserStatus(int $userId)
    {
        return Flashcard::leftJoin('flashcard_user', function($join) use ($userId) {
            $join->on('flashcards.id', '=', 'flashcard_user.flashcard_id')
                ->where('flashcard_user.user_id', '=', $userId);
        })
        ->select('flashcards.id', 'flashcards.question', DB::Raw('IFNULL( `flashcard_user`.`status`, "Not Answered") as status'));
    }
}
