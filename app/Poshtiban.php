<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
class Poshtiban extends Model
{
    use SearchableTrait;

    protected $table = 'poshtiban';
    protected $fillable = ['name', 'mobile', 'personnel_code', 'codemeli', 'status'];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'mobile' => 10,
        ],
    ];
}
