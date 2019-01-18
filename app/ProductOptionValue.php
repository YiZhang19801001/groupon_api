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
        'points_prefix' => 'P',
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
        'points_prefix',
        'weight',
        'weight_prefix',
    ];

    public function description()
    {
        return $this->hasOne('App\OptionValueDescription', 'option_value_id', 'option_value_id');
    }
}
