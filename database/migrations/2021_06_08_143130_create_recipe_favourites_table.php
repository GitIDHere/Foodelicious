<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_favourites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_profile_id');
            $table->unsignedBigInteger('recipe_id');
            $table->tinyInteger('is_favourited');
            $table->timestamps();

            $table
                ->foreign('user_profile_id')
                ->references('id')
                ->on('user_profiles')
                ->cascadeOnDelete()
            ;

            $table
                ->foreign('recipe_id')
                ->references('id')
                ->on('recipes')
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
        Schema::dropIfExists('recipe_favourites');
    }
}
