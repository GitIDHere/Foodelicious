<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cookTimeHours = $this->faker->numberBetween(0, 3);
        $cookTimeMins = $this->faker->numberBetween(1, 59);        
        $directions = json_encode([
            '1' => $this->faker->sentence,
            '2' => $this->faker->sentence,
            '3' => $this->faker->sentence,
            '4' => $this->faker->sentence,
            '5' => $this->faker->sentence,
        ]);
        
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text,
            'directions' => $directions,
            'cook_time' => $cookTimeHours.':'.$cookTimeMins,
            'utensils' => $this->faker->text,
            'servings' => $this->faker->numberBetween(1, 10),
            'prep_directions' => $this->faker->text,
            'created_at' => $this->faker->unixTime(),
        ];
    }
}
