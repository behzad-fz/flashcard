<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StatisticsTest extends TestCase
{
    use DatabaseMigrations;

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
                    'value' => ((Flashcard::where('status', '!=', 'Not Answered')->count() > 0 ? Flashcard::where('status', '!=', 'Not Answered')->count() / Flashcard::count()  : 0) * 100).' %'
                ],
                [
                    'key' => 'Correctly Answered Questions',
                    'value' => ((Flashcard::where('status', 'Correct')->count() > 0 ? Flashcard::where('status', 'Correct')->count() / Flashcard::count()  : 0) * 100).' %'
                ]
            ])
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }
}
