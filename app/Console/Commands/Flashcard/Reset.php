<?php

namespace App\Console\Commands\Flashcard;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class Reset extends Command
{
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the practice progress';

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
        system('clear');

        $this->parent->line('Report of what you have done so far:');
        $this->parent->line(sprintf('Total Number Of Questions : %s', $this->parent->getFlashcardService()->totalCount()));
        $this->parent->line(sprintf('Answered : %s %%', $this->parent->getFlashcardService()->getAnsweredCardsPercentage(Auth::user())));
        $this->parent->line(sprintf('Answered Correctly : %s %%', $this->parent->getFlashcardService()->getCorrectlyAnsweredCardsPercentage(Auth::user())));

        if ($this->parent->confirm('Do you wish to continue resetting the process?')) {
            $this->parent->getFlashcardService()->resetProgress(Auth::user());
            system('clear');
            $this->parent->info('Practice process has been reset!');
        }

        return 0;
    }
}
