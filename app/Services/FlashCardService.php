<?php

namespace App\Services;

use App\Interfaces\FlashcardServiceInterface;
use App\Models\Flashcard;

class FlashCardService implements FlashcardServiceInterface
{
    public function createNewCard(string $question, string $answer)
    {
        Flashcard::create([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function getAllCard(array $columns)
    {
        return Flashcard::all($columns)->toArray();
    }

    public function getProgressPercentage(): float
    {
        return round((Flashcard::where('status', 'Correct')->count() > 0 ? Flashcard::where('status', 'Correct')->count() / Flashcard::count()  : 0) * 100, 1);
    }

    public function isAnsweredCorrectlyBefore(string $question): bool
    {
        return (bool)Flashcard::query()->where('id', $question)->where('status', 'Correct')->first();
    }

    public function find(string $question): Flashcard|null
    {
        return Flashcard::find($question);
    }

    public function updateStatus(string $question, string $status)
    {
        return $this->find($question)->update(['status' => $status]);
    }

    public function totalCount(): int
    {
        return Flashcard::count();
    }

    public function getAnsweredCardsPercentage(): float
    {
        return round((Flashcard::where('status', '!=', 'Not Answered')->count() > 0 ? Flashcard::where('status', '!=', 'Not Answered')->count() / Flashcard::count()  : 0) * 100, 1);
    }

    public function getCorrectlyAnsweredCardsPercentage(): float
    {
        return round((Flashcard::where('status', 'Correct')->count() > 0 ? Flashcard::where('status', 'Correct')->count() / Flashcard::count()  : 0) * 100, 1);
    }

    public function resetProgress(): bool
    {
        return Flashcard::query()->update(['status' => 'Not Answered']);
    }
}
