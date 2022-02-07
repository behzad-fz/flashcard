<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateFlashCardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test when choose 1st option, gets the question and it's correct answer and creates a new flash card.
     *
     * @return void
     */
    public function test_create_a_new_flash_card()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Create a flashcard', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion('Enter the question', 'What is the smartest animal in the world?')
            ->expectsQuestion('Enter the answer', 'Polar bear')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);

        $this->assertDatabaseHas('flashcards', [
            'question' => 'What is the smartest animal in the world?',
            'answer' => 'Polar bear'
        ]);
    }
}
