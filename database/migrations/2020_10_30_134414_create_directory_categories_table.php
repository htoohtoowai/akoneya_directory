<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoryCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('directory_categories')) {
            Schema::create('directory_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('category_name');
                $table->string('category_name_mm');
                $table->string('category_name_zh')->nullable();
                $table->string('image')->nullable();
                $table->string('primary_color_code');
                $table->string('secondary_color_code');
                $table->boolean('publish_status')->default('1');
                $table->timestamps();
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
        Schema::dropIfExists('directory_categories');
    }
}
