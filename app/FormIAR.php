<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormIAR extends Model
{
    protected $table = 'iar';
    protected $fillable = [
        'modir_code',
        'bazres_code',
        'img_signature',
        'exam_id',
        'hozeh_code',
        'status',
        'date',
        'mark',
        'img_signature_bazres',
        'modir_ghayeb',
        'modir_moteakher',
        'poshtiban_ghayeb',
        'poshtiban_moteakher',
        'poshtiban_amozeshi',
        'shakhes_ghovat',
        'ekhtelal_nazm',
        'arzyabi',
        'mark_nazm',
        'mark_performance',
    ];

    public function details()
    {
        return $this->hasMany(DetailsIar::class,'iar_id');
    }


    public function modir()
    {
        return $this->belongsTo(Modir::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function bazres()
    {
        return $this->belongsTo(Bazres::class,'bazres_code','codemeli');
    }
}
