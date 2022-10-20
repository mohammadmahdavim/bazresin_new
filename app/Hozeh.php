<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hozeh extends Model
{
    protected $table = 'hozeh';
    protected $fillable = ['code', 'zone', 'name', 'address'];
}
