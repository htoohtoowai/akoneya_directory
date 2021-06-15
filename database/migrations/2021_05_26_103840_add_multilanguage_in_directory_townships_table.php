<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageInDirectoryTownshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directory_townships', function (Blueprint $table) {
            $table->text('township_name_mm')->nullable();
            $table->text('township_name_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_townships', function (Blueprint $table) {
            $table->dropColumn('township_name_mm');
        });

        Schema::table('directory_townships', function (Blueprint $table) {
            $table->dropColumn('township_name_zh');
        });
    }
}
