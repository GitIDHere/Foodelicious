<?php

namespace Database\Seeders;

use Faker\Generator;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $ingredients = $this->fromJSON('ingredients');
        
        foreach($ingredients as $ingredient)
        {
            DB::table('ingredients')->insert([
                'name' => $ingredient,
                'created_at' => $faker->unixTime(),
            ]);
        }
    }
}
