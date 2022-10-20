<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionIar extends Model
{
    protected $table = 'question_iar';
    protected $fillable = ['question', 'description', 'mark', 'status', 'type'];
    public function details()
    {
        return $this->hasMany(DetailsIar::class,'question_id');
    }

    public function gozineh()
    {
        return $this->hasMany(Gozineh::class,'question_id');
    }


}
