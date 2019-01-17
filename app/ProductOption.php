<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $table = 'oc_product_option';
    protected $primaryKey = 'product_option_id';
    public $timestamps = false;

    protected $fillable = [];
    protected $hidden = [];

    public function option()
    {
        return $this->hasOne('oc_option', 'option_id', 'option_id');
    }

    public function option_description()
    {
        return $this->hasOne('oc_option_description', 'option_id', 'option_id');
    }
}
