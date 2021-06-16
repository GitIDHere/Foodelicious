<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_metadata', function (Blueprint $table)
        {
            $table->foreignId('recipe_id')->primary()->constrained('recipes');
            $table->tinyInteger('is_published')->default(0);
            $table->tinyInteger('enable_comments')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_metadata');
    }
}
