<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'oc_location';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    protected $fillable = ['name', 'open', 'address', 'telephone'];

    protected $attributes = [
        'fax' => '',
        'geocode' => '',
        'image' => '',
        'comment' => '',
    ];
    protected $hidden = [
        'fax',
        'geocode',
        'comment',
    ];
}
