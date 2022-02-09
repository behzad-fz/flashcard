<?php

namespace App\Console\Commands\Flashcard;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Stats extends Command
{
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show flashcards statistics';

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
    public function handle(): int
    {
        $this->parent->table(
            ['Metrics', 'Statistics'],
            [
                [
                    'key' => 'Total Number Of Questions',
                    'value' => $this->parent->getFlashcardService()->totalCount()
                ],
                [
                    'key' => 'Answered Questions',
                    'value' => sprintf('%s %%', $this->parent->getFlashcardService()->getAnsweredCardsPercentage(Auth::user()))
                ],
                [
                    'key' => 'Correctly Answered Questions',
                    'value' => sprintf('%s %%', $this->parent->getFlashcardService()->getCorrectlyAnsweredCardsPercentage(Auth::user()))
                ]
            ]
        );

        return 0;
    }
}
