<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_product_description', function (Blueprint $table) {
            $table->primary(['product_id', 'language_id']);
            $table->integer('product_id', false, true)->length(11);
            $table->integer('language_id', false, true)->length(11);
            $table->string('name');
            $table->text('description');
            $table->text('tag');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keyword');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_descriptions');
    }
}
