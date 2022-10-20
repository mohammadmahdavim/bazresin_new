<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailsIar extends Model
{
    protected $table = 'details_iar';
    protected $fillable = ['iar_id','question_id', 'description', 'mark'];

    public function iar()
    {
        return $this->belongsTo(FormIar::class);
    }

    public function question()
    {
        return $this->belongsTo(QuestionIar::class);
    }
}
