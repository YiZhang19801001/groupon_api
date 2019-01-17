<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'oc_product';
    protected $primaryKey = 'product_id';
    protected $fillable = ['price', 'sku', 'quantity'];
    protected $attributes = [
        'model' => '',
        'upc' => '',
        'ean' => '',
        'jan' => '',
        'isbn' => '',
        'mpn' => '',
        'location' => '',
        'stock_status_id' => 0,
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
        'sort_order' => 1,
        'status' => 1,
        'viewed' => 1,
        'date_added' => '1900-10-11',
        'date_modified' => '1900-10-11',
        'product_tags' => '',
        'is_discount' => 1,
    ];
    protected $hidden = [
        'model',
        'upc',
        'ean',
        'jan',
        'isbn',
        'mpn',
        'location',
        'stock_status_id',
        'image',
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
        'sort_order',
        'status',
        'viewed',
        'date_added',
        'date_modified',
        'product_tags',
        'is_discount',
        'category_id'];
    public $timestamps = false;

    /**
     * Get the product's price.
     *
     * @param  decimal  $value
     * @return decimal toFixed(2)
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }

}
