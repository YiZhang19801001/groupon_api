<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $table = 'oc_product_option_value';
    protected $primaryKey = 'product_option_value_id';
    public $timestamps = false;

    protected $fillable = ['product_option_id', 'product_id', 'option_id', 'option_value_id', 'quantity', 'price'];
    protected $attributes = [
        'subtract' => 1,
        'price_prefix' => '$',
        'points' => 0,
        'points' => 'P',
        'weight' => 12.2,
        'weight_prefix' => 'G',
    ];

    protected $hidden = [
        'product_option_id',
        'product_id',
        'option_id',
        'option_value_id',
        'subtract',
        'price_prefix',
        'points',
        'points',
        'weight',
        'weight_prefix',
    ];
}
