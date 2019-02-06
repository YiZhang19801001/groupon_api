<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'oc_option';
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    protected $fillable = ['type', 'sort_order'];

    public function descriptions()
    {
        return $this->hasMany('App\OptionDescription', 'option_id', 'option_id');
    }

    public function optionValues()
    {
        return $this->hasMany('App\OptionValue', 'option_id', 'option_id');
    }

}
