<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToDirectoryCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        Schema::table('directory_categories', function (Blueprint $table) use ($driver){
            if ('sqlite' === $driver) {
                $table->string('image')->nullable()->after("category_name_mm")->default('');
            } else {
                $table->string('image')->nullable()->after("category_name_mm");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directory_categories', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
