<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('zone_id')->nullable();
            $table->string('title', 225);
            $table->text('overview');
            $table->text('history');
            $table->text('check_in_point');
            $table->string('main_image', 225);
            $table->boolean('deleted_status')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_blogs');
    }
}
