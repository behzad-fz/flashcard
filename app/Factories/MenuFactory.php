<?php

namespace App\Factories;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MenuFactory
{
    public static function make(string $subMenuName, Command $mainMenu): Command
    {
        $explode = explode(' ', $subMenuName);

        $class = "App\Console\Commands\Flashcard\\";
        foreach ($explode as $e) {
            $class .= Str::ucfirst($e);
        }

        return new $class($mainMenu);
    }
}
