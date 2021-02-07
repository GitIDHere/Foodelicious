<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_images', function (Blueprint $table) 
        {
            $table->unsignedBigInteger('file_id')->primary();
            $table->unsignedBigInteger('recipe_id');
                
            $table
                ->foreign('recipe_id')
                ->references('id')
                ->on('recipes')
            ;
            $table
                ->foreign('file_id')
                ->references('id')
                ->on('files')
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
        Schema::dropIfExists('recipe_images');
    }
}
