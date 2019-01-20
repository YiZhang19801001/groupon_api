<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('oc_product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('model');
            $table->string('sku');
            $table->string('upc');
            $table->string('ean');
            $table->string('jan');
            $table->string('isbn');
            $table->string('mpn');
            $table->string('location');
            $table->integer('quantity', false, true)->length(4);
            $table->integer('stock_status_id', false, true)->length(11);
            $table->string('image');
            $table->integer('manufacturer_id', false, true)->length(11);
            $table->tinyInteger('shipping');
            $table->decimal('price', 15, 4);
            $table->integer('points', false, true)->length(8);
            $table->integer('tax_class_id', false, true)->length(11);
            $table->date('date_available');
            $table->decimal('weight', 15, 8);
            $table->integer('weight_class_id', false, true)->length(11);
            $table->decimal('length', 15, 8);
            $table->decimal('width', 15, 8);
            $table->decimal('height', 15, 8);
            $table->integer('length_class_id', false, true)->length(11);
            $table->tinyInteger('subtract');
            $table->integer('minimum', false, true)->length(11);
            $table->integer('sort_order', false, true)->length(11);
            $table->tinyInteger('status');
            $table->integer('viewed', false, true)->length(11);
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
        Schema::dropIfExists('products');
    }
}
