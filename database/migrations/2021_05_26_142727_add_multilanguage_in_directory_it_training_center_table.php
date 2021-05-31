<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageInDirectoryItTrainingCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directory_it_training_center', function (Blueprint $table) {
            $table->string('name_mm')->nullable();
            $table->string('name_zh')->nullable();
            $table->string('address_mm', 225)->nullable();
            $table->string('address_zh', 225)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_it_training_center', function (Blueprint $table) {
            $table->dropColumn('name_mm');
        });

        Schema::table('directory_it_training_center', function (Blueprint $table) {
            $table->dropColumn('name_zh');
        });

        Schema::table('directory_it_training_center', function (Blueprint $table) {
            $table->dropColumn('address_mm');
        });

        Schema::table('directory_it_training_center', function (Blueprint $table) {
            $table->dropColumn('address_zh');
        });
    }
}
