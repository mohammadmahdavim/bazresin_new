<?php

namespace App\lib;

class RandomPass
{
	public static function random($length = 4){
      $vmsString = '123456789';
      return substr(str_shuffle($vmsString),0,$length);
    }

    public static function randomtoken($length = 20){
        $vmsString = 'abcdefghijklmnopqrstuvwxyz@123456789';
        return substr(str_shuffle($vmsString),0,$length);
    }
}

?>