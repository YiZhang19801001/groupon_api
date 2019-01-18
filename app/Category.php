<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'oc_category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = [];

    protected $attributes = [
        'image' => '',
        'parent_id' => 1,
        'top' => 1,
        'column' => 123,
        'sort_order' => 123,
        'status' => 1,
        'date_added' => '1900-10-11',
        'date_modified' => '1900-10-11',
    ];

    protected $hidden = [
        'image',
        'parent_id',
        'top',
        'column',
        'sort_order',
        'status',
        'date_added',
        'date_modified',
    ];

    public function products()
    {
        return $this->hasManyThrough('App\Product', 'App\ProductToCategory', 'category_id', 'product_id', 'category_id', 'product_id');
    }

    public function descriptions()
    {
        return $this->hasMany('App\CategoryDescription', 'category_id', 'category_id');
    }
}
