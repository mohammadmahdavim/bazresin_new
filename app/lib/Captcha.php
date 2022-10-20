<?php

namespace App\lib;

class Captcha
{

public static function catcha(){
 session_start();
    $random = mt_rand(100000,999999);
    $captcha_vms = substr($random, 0, 4);
    $_SESSION["captcha_vms"] = $captcha_vms;
    $target = imagecreatetruecolor(45,30);
    $captcha_background = imagecolorallocate($target, 255, 78, 19);
    imagefill($target,0,0,$captcha_background);
    $captcha_fore_color = imagecolorallocate($target, 0, 0, 0);
    imagestring($target, 8, 5, 5, $captcha_vms, $captcha_fore_color);
    header("Content-type: image/jpeg");
    imagejpeg($target);
    return $imge;
    }

   


}

?>