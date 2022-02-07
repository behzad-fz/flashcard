<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PracticeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test when choose 3nd option, show the progress table with each questions status.
     *
     * @return void
     */
    public function test_show_the_progress_table()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
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
                'Status'
            ], Flashcard::all(['id','question', 'status'])->toArray())
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }

    /**
     * Test when choose 3nd option, show the percentage of correctly answered questions as the tables footer.
     *
     * @return void
     */
    public function test_show_the_percentage_of_correctly_answered_questions()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsOutput(((Flashcard::where('status', 'Correct')->count() > 0 ? Flashcard::where('status', 'Correct')->count() / Flashcard::count()  : 0) * 100).' % Completed')
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }

    /**
     * Test when choose 3nd option, exit the practice menu and return to main menu if entered Q .
     *
     * @return void
     */
    public function test_exit_the_practice_menu_and_return_to_main_menu_if_entered_Q()
    {
        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }

    /**
     * Test when choose 3nd option, and entered a question number which has been
     * answered correctly before, Show user an error message .
     *
     * @return void
     */
    public function test_show_user_an_error_message_if_the_question_has_been_answered_before()
    {
        $question = Flashcard::factory()->create([
            'status' => "Correct"
        ]);

        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", $question->id)
            ->expectsOutput('You already answer that correctly! Pick another one!')
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }

    /**
     * Test when choose 3nd option, and entered a question number which has not been
     * answered correctly before, Ask user for an answer .
     *
     * @return void
     */
    public function test_ask_user_to_answer_the_question_if_question_has_not_been_answered_correctly_before()
    {
        $question = Flashcard::factory()->create();

        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", $question->id)
            ->expectsQuestion('Write your answer:', 'does not matter!')
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);
    }

    /**
     * Test when choose 3nd option, Show user an error message if the given answer to the question
     * is wrong.
     *
     * @return void
     */
    public function test_show_user_an_error_message_if_given_answer_is_wrong()
    {
        $question = Flashcard::factory()->create([
            'answer' => "Correct Answer",
            'status' => "Not Answered"
        ]);

        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", $question->id)
            ->expectsQuestion('Write your answer:', 'Wrong answer')
            ->expectsOutput('0 % Completed')
            ->expectsOutput('Sorry! Incorrect')
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);

        $question->refresh();

        $this->assertEquals('Incorrect', $question->status);
    }

    /**
     * Test when choose 3nd option, Show user a success message if the given answer to the question
     * is correct.
     *
     * @return void
     */
    public function test_show_user_a_success_message_if_given_answer_is_correct()
    {
        $question = Flashcard::factory()->create([
            'answer' => "Correct Answer",
            'status' => "Not Answered"
        ]);

        $this->artisan('flashcard:interactive')
            ->expectsChoice('What do you want to do?','Practice', [
                'Create a flashcard',
                'List all flashcards',
                'Practice',
                'Stats',
                'Reset',
                'Exit',
            ])
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", $question->id)
            ->expectsQuestion('Write your answer:', 'Correct Answer')
            ->expectsOutput('100 % Completed')
            ->expectsOutput('Bravo! Correct')
            ->expectsQuestion("press Q to quit. \n Or Pick a question to practice:", 'Q')
            ->expectsQuestion('What do you want to do?', 'Exit')
            ->assertExitCode(0);


        $question->refresh();

        $this->assertEquals('Correct', $question->status);
    }
}
