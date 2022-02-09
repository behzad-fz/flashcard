<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use DatabaseMigrations;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('email', 'default-user@system.com')->first();
        $this->actingAs($this->user);
    }

    /**
     * Test when choose 4nd option, a table appears containing statistics.
     *
     * @return void
     */
    public function test_show_the_statistics_of_users_practice()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Stats', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsTable([
                'Metrics',
                'Statistics'
            ], [
                [
                    'key' => 'Total Number Of Questions',
                    'value' => Flashcard::count()
                ],
                [
                    'key' => 'Answered Questions',
                    'value' => round(($this->user->answeredCards()->count() > 0 ? $this->user->answeredCards()->count() / Flashcard::count()  : 0) * 100, 1).' %'
                ],
                [
                    'key' => 'Correctly Answered Questions',
                    'value' => round(($this->user->correctlyAnsweredCards()->count() > 0 ? $this->user->correctlyAnsweredCards()->count() / Flashcard::count()  : 0) * 100, 1).' %'
                ]
            ])
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }
}
