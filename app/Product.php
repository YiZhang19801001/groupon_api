<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';
    protected $fillable = ['price', 'quantity', 'sort_order', "stock_status_id"];
    protected $attributes = [
        'model' => '',
        "sku" => "",
        'upc' => '',
        'ean' => '',
        'jan' => '',
        'isbn' => '',
        'mpn' => '',
        'location' => '',
        'image' => '',
        'manufacturer_id' => 0,
        'shipping' => 1,
        'points' => 0,
        'tax_class_id' => 1,
        'date_available' => '1900-10-11',
        'weight' => 12.8,
        'weight_class_id' => 1,
        'length' => 0,
        'width' => 0,
        'height' => 0,
        'length_class_id' => 0,
        'subtract' => 0,
        'minimum' => 1,
        'status' => 1,
        'viewed' => 1,
        'date_added' => '1900-10-11',
        'date_modified' => '1900-10-11',

    ];
    protected $hidden = [
        'model',
        'upc',
        'ean',
        'jan',
        'isbn',
        'mpn',
        'location',
        'manufacturer_id',
        'shipping',
        'points',
        'tax_class_id',
        'date_available',
        'weight',
        'weight_class_id',
        'length',
        'width',
        'height',
        'length_class_id',
        'subtract',
        'minimum',

        'viewed',
        'date_added',
        'date_modified',

    ];

    public $timestamps = false;

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }
    public function options()
    {
        return $this->hasMany('App\ProductOption', 'product_id', 'product_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\ProductDescription', 'product_id', 'product_id');
    }
    public function optionValues()
    {
        return $this->hasMany('App\ProductOptionValue', 'product_id', 'product_id');
    }
    public function discounts()
    {
        return $this->hasMany('App\ProductDiscount', 'product_id', 'product_id');
    }

}
