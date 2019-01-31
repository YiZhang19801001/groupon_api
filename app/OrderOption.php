<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model
{
    protected $table = "oc_order_option";
    protected $primaryKey = "order_option_id";
    public $timestamps = false;

    protected $fillable = ['order_id', 'order_product_id', 'product_option_id', 'product_option_value_id'];
    protected $attributes = ['name' => "", "value" => "", "type" => ""];
    protected $hidden = ['name', 'value', 'type'];

}
