<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadingExam extends Model
{
    protected $table = '';
    protected $fillable = ['exam_id', 'step1', 'step2', 'step3', 'step4'];
}
