<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "oc_order";
    protected $primaryKey = "order_id";
    public $timestamps = false;

    //'fax' be used as pickedDate
    protected $fillable = ['invoice_no', 'store_id', 'customer_id', 'fax', 'payment_method', 'total', 'date_added', 'date_modified', 'order_status_id'];

    protected $attributes = [
        'invoice_prefix' => "MELTIANFU",
        'store_name' => "",
        'store_url' => "",
        'customer_group_id' => 1,
        'firstname' => "",
        'lastname' => "",
        'email' => "",
        'telephone' => "",
        'custom_field' => "",
        'payment_firstname' => "",
        'payment_lastname' => "",
        'payment_company' => "",
        'payment_address_1' => "",
        "payment_address_2" => "",
        'payment_city' => "",
        'payment_postcode' => "",
        'payment_country' => "",
        'payment_country_id' => 1,
        'payment_zone' => "",
        'payment_zone_id' => 1,
        "payment_address_format" => "",
        'payment_custom_field' => "",
        'payment_code' => 1,
        'shipping_firstname' => "",
        'shipping_lastname' => "",
        'shipping_company' => "",
        'shipping_address_1' => "",
        'shipping_address_2' => "",
        'shipping_city' => "",
        'shipping_postcode' => "",
        'shipping_country' => "",
        'shipping_country_id' => 1,
        'shipping_zone' => "",
        'shipping_zone_id' => 1,
        'shipping_address_format' => "",
        'shipping_custom_field' => "",
        'shipping_method' => "",
        'shipping_code' => 1,
        'comment' => "",
        'affiliate_id' => 1,
        'commission' => 1,
        'marketing_id' => 1,
        'tracking' => "abc",
        'language_id' => 1,
        'currency_id' => 1,
        'currency_code' => "AUD",
        'currency_value' => 1.1,
        'ip' => "",
        'forwarded_ip' => "",
        'user_agent' => "",
        'accept_language' => "",
    ];

    protected $hidden = [
        'invoice_prefix',
        'store_url',
        'customer_group_id',
        'firstname',
        'lastname',
        'email',
        'telephone',
        'custom_field',
        'payment_firstname',
        'payment_lastname',
        'payment_company',
        'payment_address_1',
        "payment_address_2",
        'payment_city',
        'payment_postcode',
        'payment_country',
        'payment_country_id',
        'payment_zone',
        'payment_zone_id',
        "payment_address_format",
        'payment_custom_field',
        'payment_code',
        'shipping_firstname',
        'shipping_lastname',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_postcode',
        'shipping_country',
        'shipping_country_id',
        'shipping_zone',
        'shipping_zone_id',
        'shipping_address_format',
        'shipping_custom_field',
        'shipping_method',
        'shipping_code',
        'comment',
        'affiliate_id',
        'commission',
        'marketing_id',
        'tracking' => "abc",
        'language_id',
        'currency_id',
        'currency_code',
        'currency_value',
        'ip',
        'forwarded_ip',
        'user_agent',
        'accept_language',
    ];

    public function getTotalAttribute($value)
    {
        return number_format($value, 2);

    }

    /**
     * find user by email
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne('App\User', 'customer_id', 'user_id');
    }
    /**
     * fetch order status
     * @return void
     */
    public function status()
    {
        return $this->hasMany('App\OrderStatus', 'order_status_id', 'order_status_id');
    }
}
