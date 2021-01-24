<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredient_pivot', function (Blueprint $table) 
        {
            $table->unsignedBigInteger('recipe_id')->index();
            $table->unsignedBigInteger('ingredient_id')->index();
            
            $table
                ->foreign('recipe_id')
                ->references('id')
                ->on('recipes')
            ;
            
            $table
                ->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
            ;
            
            $table->primary(['recipe_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredient_pivot');
    }
}
