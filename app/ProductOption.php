<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'oc_product_option';
    protected $primaryKey = 'product_option_id';
    public $timestamps = false;

    protected $fillable = ['product_id', 'option_id', 'value', 'required'];
    protected $hidden = ['product_id'];

    public function option()
    {
        return $this->hasOne('App\Option', 'option_id', 'option_id');
    }

    public function optionDescriptions()
    {
        return $this->hasMany('App\OptionDescription', 'option_id', 'option_id');
    }
    public function optionValues()
    {
        return $this->hasMany('App\ProductOptionValue', 'product_option_id', 'product_option_id');
    }

}
