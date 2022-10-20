<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BazresHozeh extends Model
{
    protected $table = 'bazres_hozeh';
    protected $fillable = ['exam_id', 'hozeh_code', 'bazres_code', 'date'];
}
