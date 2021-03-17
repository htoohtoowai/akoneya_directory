<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('title', 200);
            $table->string('title_mm', 200);
            $table->string('title_zh', 200);
            $table->text('ingredients', 1000);
            $table->text('ingredients_mm', 1000);
            $table->text('ingredients_zh', 1000);
            $table->text('directions', 1000);
            $table->text('directions_mm', 1000);
            $table->text('directions_zh', 1000);
            $table->string('note', 200);
            $table->string('note_mm', 200);
            $table->string('note_zh', 200);
            $table->string('credit', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
}
