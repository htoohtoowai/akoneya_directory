<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageInDirectoryBusinessTrainingCenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directory_business_training_center', function (Blueprint $table) {
            $table->text('name_mm')->nullable();
            $table->text('name_zh')->nullable();
            $table->text('address_mm')->nullable();
            $table->text('address_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_business_training_center', function (Blueprint $table) {
            $table->dropColumn('name_mm');
        });

        Schema::table('directory_business_training_center', function (Blueprint $table) {
            $table->dropColumn('name_zh');
        });

        Schema::table('directory_business_training_center', function (Blueprint $table) {
            $table->dropColumn('address_mm');
        });

        Schema::table('directory_business_training_center', function (Blueprint $table) {
            $table->dropColumn('address_zh');
        });
    }
}
