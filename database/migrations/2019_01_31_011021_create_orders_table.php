<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oc_order', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('invoice_no', false, true)->length(11);
            $table->string('invoice_prefix');
            $table->integer('store_id', false, true)->length(11);
            $table->string('store_name');
            $table->string('store_url');
            $table->integer('customer_id', false, true)->length(11);
            $table->integer('customer_group_id', false, true)->length(11);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('telephone');
            $table->string('fax');
            $table->text('custom_field');
            $table->string('payment_firstname');
            $table->string('payment_lastname');
            $table->string('payment_company');
            $table->string('payment_address_1');
            $table->string('payment_address_2');
            $table->string('payment_city');
            $table->string('payment_postcode');
            $table->string('payment_country');
            $table->integer('payment_country_id', false, true)->length(11);
            $table->string('payment_zone');
            $table->integer('payment_zone_id', false, true)->length(11);
            $table->text('payment_address_format');
            $table->text('payment_custom_field');
            $table->string('payment_method');
            $table->string('payment_code');
            $table->string('shipping_firstname');
            $table->string('shipping_lastname');
            $table->string('shipping_company');
            $table->string('shipping_address_1');
            $table->string('shipping_address_2');
            $table->string('shipping_city');
            $table->string('shipping_postcode');
            $table->string('shipping_country');
            $table->integer('shipping_country_id', false, true)->length(11);
            $table->string('shipping_zone');
            $table->integer('shipping_zone_id', false, true)->length(11);
            $table->text('shipping_address_format');
            $table->text('shipping_custom_field');
            $table->string('shipping_method');
            $table->string('shipping_code');
            $table->text('comment');
            $table->decimal('total', 15, 4);
            $table->integer('order_status_id', false, true)->length(11);
            $table->integer('affiliate_id', false, true)->length(11);
            $table->decimal('commission', 15, 4);
            $table->integer('marketing_id', false, true)->length(11);
            $table->string('tracking');
            $table->integer('language_id', false, true)->length(11);
            $table->integer('currency_id', false, true)->length(11);
            $table->string('currency_code');
            $table->decimal('currency_value', 15, 8);
            $table->string('ip');
            $table->string('forwarded_ip');
            $table->string('user_agent');
            $table->string('accept_language');
            $table->datetime('date_added');
            $table->datetime('date_modified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
