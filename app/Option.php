<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'oc_option';
    protected $primaryKey = 'option_id';
    public $timestamps = false;

    protected $fillable = ['type', 'sort_order'];

}
