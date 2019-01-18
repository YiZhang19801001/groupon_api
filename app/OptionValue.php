<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $table = 'oc_option_value';
    protected $primaryKey = 'option_value_id';
    public $timestamps = false;

    protected $fillable = ['option_id'];

    protected $attributes = ['image' => '', 'sort_order' => 1];

    public function description()
    {
        return $this->hasOne('App\OptionValueDescription', 'option_value_id', 'option_value_id');
    }
}
