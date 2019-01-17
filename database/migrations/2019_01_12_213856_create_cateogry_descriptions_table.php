<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateogryDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_category_description', function (Blueprint $table) {
            $table->primary(['category_id', 'language_id']);
            $table->integer('category_id', false, true)->length(11);
            $table->integer('language_id', false, true)->length(11);
            $table->string('name', 255);
            $table->text('description');
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
            $table->string('meta_keyword', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cateogry_descriptions');
    }
}
