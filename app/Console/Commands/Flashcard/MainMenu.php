<?php

namespace App\Console\Commands\Flashcard;

use App\Factories\MenuFactory;
use App\Interfaces\FlashcardServiceInterface;
use Illuminate\Console\Command;

class MainMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start flash cards application';

    /**
     * Main menu items.
     *
     * @var array
     */
    private array $menuItems = [
        'Create a flashcard',
        'List all flashcards',
        'Practice',
        'Stats',
        'Reset',
        'Exit',
    ];

    private MenuFactory $factory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private FlashcardServiceInterface $flashcardService
    ) {
        $this->factory = new MenuFactory($this);
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

        while ('Exit' !== $choice = $this->choice('What do you want to do?', $this->menuItems,2,5)) {
            system('clear');
            $subMenu = $this->factory->make($choice);
            $subMenu->handle();
        }

        return 0;
    }

    public function getFlashcardService(): FlashcardServiceInterface
    {
        return $this->flashcardService;
    }
}
