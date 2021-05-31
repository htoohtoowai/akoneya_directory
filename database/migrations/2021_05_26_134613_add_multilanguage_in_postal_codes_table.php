<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageInPostalCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('postal_codes', function (Blueprint $table) {
            $table->text('area_name_mm')->nullable();
            $table->text('area_name_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postal_codes', function (Blueprint $table) {
            $table->dropColumn('area_name_mm');
        });

        Schema::table('postal_codes', function (Blueprint $table) {
            $table->dropColumn('area_name_zh');
        });
    }
}
