<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    protected $fillable = ['name'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
