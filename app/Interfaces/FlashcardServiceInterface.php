<?php

namespace App\Interfaces;

use App\Models\Flashcard;
use App\Models\User;

interface FlashcardServiceInterface
{
    public function createNewCard(string $question, string $answer): void;

    public function getAllCard(array $columns): array;

    public function getAllCardsWithCurrentUserStatus(int $userId): array;

    public function isAnsweredCorrectlyBefore(int $flashcardId, User $user): bool;

    public function find(string $question): Flashcard|null;

    public function updateStatus(int $cardId, string $status, User $user): void;

    public function totalCount(): int;

    public function getAnsweredCardsPercentage(User $user): float;

    public function getCorrectlyAnsweredCardsPercentage(User $user): float;

    public function resetProgress(User $user): bool;

    public function getDefaultUser(): User;
}
