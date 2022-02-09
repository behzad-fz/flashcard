<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cards()
    {
        return $this->belongsToMany(Flashcard::class)->withPivot('status');
    }

    public function answeredCards()
    {
        return $this->belongsToMany(Flashcard::class)->wherePivot('status', '!=', Flashcard::STATUS_NOT_ANSWERED);
    }

    public function notAnsweredCards()
    {
        return Flashcard::query()->whereNotIn('id', $this->answeredCards()->get()->pluck('id')->toArray());
    }

    public function correctlyAnsweredCards()
    {
        return $this->belongsToMany(Flashcard::class)->wherePivot('status', Flashcard::STATUS_CORRECT);
    }

    public function IncorrectlyAnsweredCards()
    {
        return $this->belongsToMany(Flashcard::class)->wherePivot('status', Flashcard::STATUS_INCORRECT);
    }

    public function hasAnsweredCorrectlyBefore($flashcardId): bool
    {
        return (bool) $this->correctlyAnsweredCards()->wherePivot('flashcard_id', $flashcardId)->first();
    }
}
