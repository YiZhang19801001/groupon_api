<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_product_option_value', function (Blueprint $table) {
            $table->increments('product_option_value_id');
            $table->integer('product_option_id', false, true)->length(11);
            $table->integer('product_id', false, true)->length(11);
            $table->integer('option_id', false, true)->length(11);
            $table->integer('option_value_id', false, true)->length(11);
            $table->integer('quantity', false, true)->length(3);
            $table->tinyInteger('subtract');
            $table->decimal('price', 15, 4);
            $table->string('price_prefix', 1);
            $table->integer('points', false, true)->length(8);
            $table->string('points_prefix', 1);
            $table->decimal('weight', 15, 8);
            $table->string('weight_prefix', 1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_option_values');
    }
}
