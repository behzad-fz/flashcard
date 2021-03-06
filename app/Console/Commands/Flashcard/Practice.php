<?php

namespace App\Console\Commands\Flashcard;

use App\Models\Flashcard;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Practice extends Command
{
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Practice flashcards';

    private MainMenu $parent;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MainMenu $parent)
    {
        $this->parent = $parent;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $firstTime = true;

        while (true) {

            if ($firstTime) {
                $this->printTable();
                $firstTime = false;
            }

            if ('Q' === Str::upper($question = $this->parent->ask("press Q to quit. \n Or Pick a question to practice:")) ) {
                system('clear');
                break;
            }

            $validator = Validator::make(
                [
                    'id' => $question
                ],
                [
                    'id' => 'required|numeric',
                ],
                [
                    'required' => 'Enter a question id from the table',
                ]
            );

            if ($validator->errors()->count()) {
                $this->parent->error($validator->errors()->first());
                continue;
            }

            if ($this->parent->getFlashcardService()->isAnsweredCorrectlyBefore($question)) {
                system('clear');
                $this->printTable();
                $this->parent->error('You already answer that correctly! Pick another one!');
                continue;
            }

            if (! $q = $this->parent->getFlashcardService()->find($question)) {
                $this->parent->error(sprintf('Flashcard with id %s does not exist!', $question));
                continue;
            }

            if ($q->answer === $this->parent->ask('Write your answer:')) {
                $this->parent->getFlashcardService()->updateStatus($question, Flashcard::STATUS_CORRECT);
                system('clear');

                $this->printTable();
                $this->parent->info('Bravo! Correct');
            } else {
                $this->parent->getFlashcardService()->updateStatus($question, Flashcard::STATUS_INCORRECT);
                system('clear');
                $this->printTable();
                $this->parent->error('Sorry! Incorrect');
            }
        };

        return 0;
    }

    private function printTable()
    {
        $this->parent->table(
            ['#', 'Questions', 'Status'],
            $this->parent->getFlashcardService()->getAllCard(['id','question', 'status'])
        );
        $this->parent->line(sprintf("%s %% Completed", $this->parent->getFlashcardService()->getProgressPercentage()));
    }
}
