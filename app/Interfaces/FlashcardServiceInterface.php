<?php

namespace App\Interfaces;

use App\Models\Flashcard;

interface FlashcardServiceInterface
{
    public function createNewCard(string $question, string $answer);

    public function getAllCard(array $columns);

    public function getProgressPercentage(): float;

    public function isAnsweredCorrectlyBefore(string $question): bool;

    public function find(string $question): Flashcard|null;

    public function updateStatus(string $question, string $status);

    public function totalCount(): int;

    public function getAnsweredCardsPercentage(): float;

    public function getCorrectlyAnsweredCardsPercentage(): float;

    public function resetProgress(): bool;
}
