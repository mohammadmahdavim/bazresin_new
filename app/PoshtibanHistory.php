<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoshtibanHistory extends Model
{
    protected $table = 'poshtiban_histories';
    protected $fillable = [
        'exam_id',
        'targets',
        'debility',
        'quality_face',
        'quality_performance',
        'quality_face_mark',
        'quality_performance_mark',
        'date',
        'poshtiban_code',
        'bazres_code'
    ];

    public function bazres()
    {
        return $this->belongsTo(Bazres::class,'bazres_code','codemeli');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
