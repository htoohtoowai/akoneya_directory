<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageInBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
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
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('name_mm');
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('name_zh');
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('address_mm');
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('address_zh');
        });
    }
}
