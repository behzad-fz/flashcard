<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ResetPracticeProcessTest extends TestCase
{
    use DatabaseMigrations;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('email', 'default-user@system.com')->first();
        $this->actingAs($this->user);

        Flashcard::factory(4)->create();

        $this->user->cards()->syncWithoutDetaching([
            1 => ['status' => 'Correct'],
            2 => ['status' => 'Incorrect'],
        ]);
    }

    /**
     * Test when choose 5nd option, show a confirmation.
     * decline the reset request when not confirmed
     *
     * @return void
     */
    public function test_decline_reset_request_if_not_confirmed()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Reset', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsConfirmation('Do you wish to continue resetting the process?', 'no')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);

        $this->assertCount(1, $this->user->correctlyAnsweredCards);
        $this->assertCount(1, $this->user->IncorrectlyAnsweredCards);
        $this->assertCount(2, $this->user->notAnsweredCards()->get());
    }

    /**
     * Test when choose 5nd option, show a confirmation.
     * decline the reset request when not confirmed
     *
     * @return void
     */
    public function test_reset_practice_process_and_start_fresh_if_reset_request_confirmed()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Reset', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsConfirmation('Do you wish to continue resetting the process?', 'yes')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);

        $this->assertCount(0, $this->user->correctlyAnsweredCards);
        $this->assertCount(0, $this->user->IncorrectlyAnsweredCards);
        $this->assertCount(4, $this->user->notAnsweredCards()->get());
    }
}
