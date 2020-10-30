<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorySubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('directory_subcategories')) {
            Schema::create('directory_subcategories', function (Blueprint $table) {
                $table->id();
                $table->string('subcategory_name');
                $table->string('subcategory_name_mm');
                $table->string('subcategory_name_zh')->nullable();
                $table->string('service_code');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->boolean('deleted_status')->default('0');
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
        Schema::dropIfExists('directory_subcategories');
    }
}
