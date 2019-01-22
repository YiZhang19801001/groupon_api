<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'oc_user';
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = [
        'username', 'email', 'password', 'api_token',
    ];

    protected $attributes = [
        'user_group_id' => 1,
        'salt' => '',
        'firstname' => '',
        'lastname' => '',
        'image' => '',
        'code' => '',
        'ip' => '',
        'status' => 0,
        'date_added' => '1900-10-10',
    ];
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
