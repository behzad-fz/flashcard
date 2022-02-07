<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ListAllFlashCardsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test when choose 2nd option, a table appears containing all the flash cards in the database.
     *
     * @return void
     */
    public function test_get_all_flash_cards()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','List all flashcards', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsTable([
                '#',
                'Questions',
                'Answers'
            ], Flashcard::all(['id','question', 'answer'])->toArray())
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }
}
