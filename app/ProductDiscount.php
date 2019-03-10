<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = "oc_product_discount";
    protected $primaryKey = "product_discount_id";
    public $timestamps = false;
}
