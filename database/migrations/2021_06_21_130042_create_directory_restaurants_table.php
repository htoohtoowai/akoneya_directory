<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_mm')->nullable();
            $table->string('name_zh')->nullable();
            $table->unsignedBigInteger('township_id')->nullable();
            $table->unsignedInteger('zone_id')->nullable();
            $table->string('address', 225);
            $table->string('address_mm', 225)->nullable();
            $table->string('address_zh', 225)->nullable();
            $table->string('phone', 225);
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
        Schema::dropIfExists('directory_restaurants');
    }
}
