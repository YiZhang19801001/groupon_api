<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_order_product', function (Blueprint $table) {
            $table->increments('order_product_id');
            $table->integer('order_id', false, true)->length(11);
            $table->integer('product_id', false, true)->length(11);
            $table->string('name');
            $table->string('model');
            $table->integer('quantity', false, true)->length(4);
            $table->decimal('price', 15, 4);
            $table->decimal('total', 15, 4);
            $table->decimal('tax', 15, 4);
            $table->integer('reward', false, true)->length(8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
