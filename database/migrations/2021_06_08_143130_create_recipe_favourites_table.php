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
            $table->foreignId('user_profile_id')->constrained('user_profiles');
            $table->foreignId('recipe_id')->constrained('recipes');
            $table->tinyInteger('is_favourited');
            $table->timestamps();
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
