<?php

namespace App\lib;

class Kavenegar
{

    public static function sendSMS($mobile,$token,$template){

        /*
         * Author: M.Fakhrani
         * Description : for send sms whit algorithm on kavenegar by API
         */
        $token2 = config('global.Municipality');
        $url = 'https://api.kavenegar.com/v1/7135636A51366D742F4664305A556B672B317764574D52502B2F386D36706E62/verify/lookup.json?receptor='.$mobile.'&token='.$token.'&token2='.$token2.'&template='.$template;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        curl_close ($ch);
       // return $response;

    }

}

?>
