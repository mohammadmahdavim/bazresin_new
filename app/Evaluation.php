<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected  $fillable = [
        'event',
        'codemeli',
        'description',
        'date',
        'targets',
    ];
}
