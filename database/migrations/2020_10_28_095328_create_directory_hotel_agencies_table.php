<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryHotelAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('directory_hotel_agencies')) {
            Schema::create('directory_hotel_agencies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('township_id')->nullable();
                $table->unsignedInteger('zone_id')->nullable();
                $table->string('address', 225);
                $table->string('phone',255);
                $table->boolean('deleted_status')->default('0');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_hotel_agencies');
    }
}
