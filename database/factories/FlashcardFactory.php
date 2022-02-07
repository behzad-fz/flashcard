<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlashcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->text(),
            'answer' => $this->faker->text(),
        ];
    }
}
