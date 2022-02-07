<?php

namespace App\Console\Commands\Flashcard;

use Illuminate\Console\Command;

class ListAllFlashcards extends Command
{
    protected $hidden = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all flashcards';

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

        $this->parent->table(
            ['#','Questions', 'Answers'],
            $this->parent->getFlashcardService()->getAllCard(['id','question', 'answer'])
        );

        return 0;
    }
}
