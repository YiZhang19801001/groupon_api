<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_location', function (Blueprint $table) {
            $table->increments('location_id');
            $table->string('name');
            $table->text('address');
            $table->string('telephone');
            $table->string('fax');
            $table->string('geocode');
            $table->string('image');
            $table->text('open');
            $table->text('comment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
