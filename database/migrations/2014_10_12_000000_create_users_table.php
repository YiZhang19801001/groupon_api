<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('salt');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('image');
            $table->string('code');
            $table->string('ip');
            $table->tinyInteger('status');
            $table->dateTime('date_added');
            $table->text('api_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oc_user');
    }
}
