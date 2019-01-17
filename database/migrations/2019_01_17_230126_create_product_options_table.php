<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_product_option', function (Blueprint $table) {
            $table->increments('product_option_id');
            $table->integer('product_id', false, true)->length(11);
            $table->integer('option_id', false, true)->length(11);
            $table->text('value');
            $table->tinyInteger('required');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
}
