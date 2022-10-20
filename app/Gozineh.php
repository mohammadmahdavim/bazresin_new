<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gozineh extends Model
{
    protected $table = 'gozineh';
    protected $fillable = ['question_id', 'name'];

    public function question()
    {
        return $this->belongsTo(QuestionIar::class);
    }
}
