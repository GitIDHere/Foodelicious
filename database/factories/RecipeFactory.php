<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * @param $multipleOf
     * @param $min
     * @param $max
     * @return mixed
     */
    private function getMultipleOf($multipleOf, $min, $max)
    {
        $list = [];
        for ($i = $min; $i <= $max; $i += $multipleOf) {
            $list[] = $i;
        }

        $k = array_rand($list);

        return ($list[$k]);
    }


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cookTimeHours = $this->faker->numberBetween(0, 3);
        $cookTimeMins = $this->getMultipleOf(5, 0, 55);
        $cookingSteps = [
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
        ];
        $ingredients = $this->faker->words;
        $utensils = $this->faker->words;

        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text,
            'cooking_steps' => $cookingSteps,
            'cook_time' => Str::padLeft($cookTimeHours, 2, 0).':'.Str::padLeft($cookTimeMins, 2, 0),
            'utensils' => $utensils,
            'servings' => $this->faker->numberBetween(1, 10),
            'ingredients' => $ingredients,
            'created_at' => $this->faker->unixTime(),
        ];
    }
}
