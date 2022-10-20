<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use Notifiable;
    use SearchableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'mobile', 'sex', 'codemeli', 'password', 'avatar', 'api_token', 'verifiysms', 'email', 'role', 'token_2fa', 'token_2fa_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];


    public function generateToken()
    {
        $this->api_token = str_random(50);
        $this->save();
        return $this->api_token;
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class);
    }

    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.first_name' => 10,
            'users.last_name' => 10,
            'users.mobile' => 2,
            'users.codemeli' => 2,
        ],
        'joins' => [
            'bazres' => ['users.codemeli','bazres.codemeli'],
        ],
    ];

    public function bazres()
    {
        return $this->hasOne(Bazres::class, 'codemeli','codemeli');
    }
}
