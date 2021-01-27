<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) 
        {
            $table->id();
            $table->unsignedBigInteger('user_profile_id');
            $table->string('title');
            $table->text('description');
            $table->json('directions');
            $table->string('cook_time', 50);
            $table->smallInteger('servings');
            $table->text('utensils');
            $table->text('prep_directions');
            $table->json('ingredients');
            $table->timestamps();
    
            $table
                ->foreign('user_profile_id')
                ->references('id')
                ->on('user_profiles')
                ->cascadeOnDelete()
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
