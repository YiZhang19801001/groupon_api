<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('image', 255);
            $table->integer('parent_id', false, true)->length(11);
            $table->tinyInteger('top');
            $table->integer('column', false, true)->length(3);
            $table->integer('sort_order', false, true)->length(3);
            $table->tinyInteger('status');
            $table->dateTime('date_added');
            $table->dateTime('date_modified');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
