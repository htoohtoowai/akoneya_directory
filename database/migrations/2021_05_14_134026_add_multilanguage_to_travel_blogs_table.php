<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultilanguageToTravelBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->text('title_mm')->nullable();
            $table->text('title_zh')->nullable();
            $table->text('overview_mm')->nullable();
            $table->text('overview_zh')->nullable();
            $table->text('history_mm')->nullable();
            $table->text('history_zh')->nullable();
            $table->text('check_in_point_mm')->nullable();
            $table->text('check_in_point_zh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('title_mm');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('title_zh');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('overview_mm');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('overview_zh');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('history_mm');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('history_zh');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('check_in_point_mm');
        });

        Schema::table('travel_blogs', function (Blueprint $table) {
            $table->dropColumn('check_in_point_zh');
        });
    }
}
