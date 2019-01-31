<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_order_option', function (Blueprint $table) {
            $table->increments('order_option_id');
            $table->integer('order_id', false, true)->length(11);
            $table->integer('order_product_id', false, true)->length(11);
            $table->integer('product_option_id', false, true)->length(11);
            $table->integer('product_option_value_id', false, true)->length(11);
            $table->string('name');
            $table->text('value');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_options');
    }
}
