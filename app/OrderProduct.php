<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = "oc_order_product";
    protected $primaryKey = "order_product_id";
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total'];

    protected $attributes = [
        'name' => "",
        "model" => "",
        "tax" => 0,
        'reward' => 0,
    ];

    protected $hidden = [
        'name',
        'model',
        "reward",
    ];

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);

    }

    public function getTotalAttribute($value)
    {
        return number_format($value, 2);

    }
}
