<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryTownshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('directory_townships')) {

            Schema::create('directory_townships', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('township_name');
                $table->unsignedInteger('zone_id');
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
        Schema::dropIfExists('directory_townships');
    }
}
