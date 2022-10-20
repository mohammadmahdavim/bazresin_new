<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BazresHistory extends Model
{
    protected $table = 'bazres_histories';
    protected $fillable = [
        'bazres_code',
        'exam_id',
        'start_exam',
        'finish_exam',
        'hozeh_code',
        'hozeh_mark',
        'lat',
        'long'
    ];
}
