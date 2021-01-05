<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelSavedBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_saved_blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_user_id');
            $table->unsignedInteger('travel_blog_id');
            $table->dateTime('created_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_saved_blogs');
    }
}
