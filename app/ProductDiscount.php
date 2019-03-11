<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = "oc_product_discount";
    protected $primaryKey = "product_discount_id";
    protected $fillable = ["product_id", "quantity", "price", "date_start", "date_end"];
    protected $attributes = [
        "customer_group_id" => 2,
        "priority" => 1,

    ];
    public $timestamps = false;
}
