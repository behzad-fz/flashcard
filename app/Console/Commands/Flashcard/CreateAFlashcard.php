<?php

namespace App\Console\Commands\Flashcard;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAFlashcard extends Command
{
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new flashcard';

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
        $question = $this->askForQuestion();
        $answer = $this->askForAnswer();

        $this->parent->getFlashcardService()->createNewCard($question, $answer);

        $this->parent->info('New flashcard added.');
        sleep(3);
        system('clear');

        return 0;
    }

    private function askForQuestion()
    {
        do {
            $question = $this->parent->ask('Enter the question');

            $validator = Validator::make(
                [
                    'question'  => $question,
                ],
                [
                'question' => 'required|min:3',
                ]
            );

            if ($validator->errors()) {
                $this->parent->error($validator->errors()->first());
            }

        } while ($validator->fails());

        return $question;
    }

    private function askForAnswer()
    {
        do {
            $answer = $this->parent->ask('Enter the answer');

            $validator = Validator::make(
                [
                    'answer' => $answer
                ],
                [
                    'answer' => 'required|min:3'
                ]
            );

            if ($validator->errors()) {
                $this->parent->error($validator->errors()->first());
            }

        } while ($validator->fails());

        return $answer;
    }
}
