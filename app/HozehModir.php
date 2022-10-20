<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HozehModir extends Model
{
    protected $table = 'hozeh_modir';
    public $timestamps = false;
    protected $fillable = ['modir_code', 'hozeh_code', 'exam_id', 'bazres_code'];
}
