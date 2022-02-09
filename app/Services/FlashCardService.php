<?php

namespace App\Services;

use App\Interfaces\FlashcardServiceInterface;
use App\Models\Flashcard;
use App\Models\User;

class FlashCardService implements FlashcardServiceInterface
{
    public function createNewCard(string $question, string $answer): void
    {
        Flashcard::create([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function getAllCard(array $columns): array
    {
        return Flashcard::all($columns)->toArray();
    }

    public function getAllCardsWithCurrentUserStatus(int $userId): array
    {
        return Flashcard::getAllWithCurrentUserStatus($userId)->get()->toArray();
    }

    public function isAnsweredCorrectlyBefore(int $flashcardId, User $user): bool
    {
        return $user->hasAnsweredCorrectlyBefore($flashcardId);
    }

    public function find(string $question): Flashcard|null
    {
        return Flashcard::find($question);
    }

    public function updateStatus(int $cardId, string $status, User $user): void
    {
        $user->cards()->syncWithoutDetaching([$cardId => ['status' => $status]]);
    }

    public function totalCount(): int
    {
        return Flashcard::count();
    }

    public function getAnsweredCardsPercentage(User $user): float
    {
        $answered = $user->answeredCards()->count();

        return round(($answered > 0 ? $answered / Flashcard::count()  : 0) * 100, 1);
    }

    public function getCorrectlyAnsweredCardsPercentage(User $user): float
    {
        $corrects = $user->correctlyAnsweredCards()->count();

        return round(($corrects > 0 ? $corrects / Flashcard::count()  : 0) * 100, 1);
    }

    public function resetProgress(User $user): bool
    {
        return $user->cards()->detach();
    }

    public function getDefaultUser(): User
    {
        return User::firstOrCreate(
            ['email'  => 'default-user@system.com'],
            [
                'name'  => 'system default user',
                'email'  => 'default-user@system.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
        );
    }
}
