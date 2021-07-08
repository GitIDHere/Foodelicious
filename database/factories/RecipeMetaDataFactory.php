<?php

namespace Database\Factories;

use App\Models\RecipeMetaData;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeMetaDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeMetaData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'is_published' => $this->faker->numberBetween(0, 1),
            'enable_comments' => $this->faker->numberBetween(0, 1),
        ];
    }
}
