<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyModel extends Model
{
    protected $table='tbl_verify_sms';
    protected $fillable = ['mobile', 'code', 'date', 'user_id'];
}
