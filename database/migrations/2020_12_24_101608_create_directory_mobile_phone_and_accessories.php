<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryMobilePhoneAndAccessories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_mobile_phone_and_accessories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('township_id')->nullable();
            $table->unsignedInteger('zone_id')->nullable();
            $table->string('address', 225);
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
        Schema::dropIfExists('directory_mobile_phone_and_accessories');
    }
}
