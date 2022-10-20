<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bazres extends Model
{
    protected $table = 'bazres';
    protected $fillable = ['name', 'mobile', 'personnel_code', 'codemeli', 'status'];

    public function user()
    {
        return $this->hasOne(User::class, 'codemeli', 'codemeli');
    }

    public static function bazres($codemeli)
    {
        $bazres = Bazres::where('codemeli', $codemeli)->first();
        if ($bazres == null) {
            return 'بدون بازرس';
        }
        return $bazres->name;
    }

    public function iar()
    {
        return $this->hasMany(FormIAR::class, 'codemeli', 'bazres_code');
    }

    public function poshtiban()
    {
        return $this->hasMany(PoshtibanHistory::class,'codemeli','bazres_code');
    }
}
