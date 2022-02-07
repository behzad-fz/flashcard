<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MainMenuTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test if main menu appears when application starts.
     *
     * @return void
     */
    public function test_show_menu_when_run_application()
    {
        $this->artisan('flashcard:interactive')
            ->assertSuccessful()
            ->expectsChoice('What do you want to do?','Exit', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->assertExitCode(0);
    }

    /**
     * Test terminate the application.
     *
     * @return void
     */
    public function test_exit_application_when_chosen_exit_option()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What do you want to do?','Exit')
            ->assertExitCode(0);
    }
}
