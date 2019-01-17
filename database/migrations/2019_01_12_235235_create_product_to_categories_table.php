<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_product_to_category', function (Blueprint $table) {
            $table->primary(['product_id', 'category_id']);
            $table->Integer('product_id', false, true)->length(11);
            $table->Integer('category_id', false, true)->length(11);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_to_categories');
    }
}
