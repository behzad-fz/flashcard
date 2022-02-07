<?php

namespace App\Providers;

use App\Exceptions\InvalidUserModeException;
use App\Interfaces\FlashcardServiceInterface;
use App\Services\FlashCardService;
use App\Services\MultiUsersFlashCardService;
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
        if(Config::get('flashcard.user_mode') === "single-user") {
            $this->app->bind(FlashcardServiceInterface::class, FlashCardService::class);
        } else {
            throw new InvalidUserModeException();
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
