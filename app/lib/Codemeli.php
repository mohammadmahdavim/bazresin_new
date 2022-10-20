<?php

namespace App\lib;

class Codemeli
{



public static function Code($input) {
    if (!preg_match("/^\d{10}$/", $input)
|| $input=='0000000000'
|| $input=='1111111111'
|| $input=='2222222222'
|| $input=='3333333333'
|| $input=='4444444444'
|| $input=='5555555555'
|| $input=='6666666666'
|| $input=='7777777777'
|| $input=='8888888888'
|| $input=='9999999999') {
        return false;
    }
    $check = (int) $input[9];
    $sum = array_sum(array_map(function ($x) use ($input) {
        return ((int) $input[$x]) * (10 - $x);
    }, range(0, 8))) % 11;
    return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
}
}

?>