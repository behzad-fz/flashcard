<?php

namespace App\Providers;

use App\Exceptions\InvalidUserModeException;
use App\Interfaces\FlashcardServiceInterface;
use App\Services\FlashCardService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlashcardServiceInterface::class, FlashCardService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Config::get('flashcard.user_mode') !== "single-user") {
            throw new InvalidUserModeException();
        }
    }
}
