<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "oc_permission";
    protected $primaryKey = "permission_id";
    public $timestamps = false;

}
