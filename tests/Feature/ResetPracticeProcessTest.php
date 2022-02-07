<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ResetPracticeProcessTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test when choose 5nd option, show a confirmation.
     * decline the reset request when not confirmed
     *
     * @return void
     */
    public function test_decline_reset_request_if_not_confirmed()
    {
        Flashcard::factory(4)->create();
        Flashcard::query()->where('id', 1)->update(['status' => 'Correct']);
        Flashcard::query()->where('id', 2)->update(['status' => 'Incorrect']);

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

        $this->assertCount(1, Flashcard::query()->where('status', 'Correct')->get());
        $this->assertCount(1, Flashcard::query()->where('status', 'Incorrect')->get());
        $this->assertCount(2, Flashcard::query()->where('status', 'Not Answered')->get());
    }

    /**
     * Test when choose 5nd option, show a confirmation.
     * decline the reset request when not confirmed
     *
     * @return void
     */
    public function test_reset_practice_process_and_start_fresh_if_reset_request_confirmed()
    {
        Flashcard::factory(4)->create();
        Flashcard::query()->where('id', 1)->update(['status' => 'Correct']);
        Flashcard::query()->where('id', 2)->update(['status' => 'Incorrect']);

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

        $this->assertCount(0, Flashcard::query()->where('status', 'Correct')->get());
        $this->assertCount(0, Flashcard::query()->where('status', 'Incorrect')->get());
        $this->assertCount(4, Flashcard::query()->where('status', 'Not Answered')->get());
    }
}
