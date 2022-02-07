<?php

namespace App\Factories;

use Illuminate\Support\Str;

class MenuFactory
{
    private $parent;
    public function __construct($parent)
    {
        $this->parent = $parent;
    }
    public function make($name)
    {
        $explode = explode(' ', $name);

        $class = "App\Console\Commands\Flashcard\\";
        foreach ($explode as $e) {
            $class .= Str::ucfirst($e);
        }

        return new $class($this->parent);
    }
}
