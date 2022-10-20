<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModirPoshtiban extends Model
{
    protected $table = 'modir_poshtiban';
    protected $fillable = ['modir_code', 'poshtiban_code', 'exam_id'];
}
