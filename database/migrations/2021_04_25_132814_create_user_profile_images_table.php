<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_images', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->primary();
            $table->unsignedBigInteger('user_profile_id');

            $table
                ->foreign('user_profile_id')
                ->references('id')
                ->on('user_profiles')
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
        Schema::dropIfExists('user_profile_images');
    }
}
