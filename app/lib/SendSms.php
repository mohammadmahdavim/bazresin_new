<?php

namespace App\lib;

class SendSms
{

    /*
     * author: M.Fakhrani
     * title: send sms
     * description: 3 parameter to send sms whit kavenegar whit protochol curl
     */
    public static function send($mobile,$token,$template){
        $url = 'https://api.kavenegar.com/v1/4A352B4F316D542B5550516E3775504561736B6D656D7859316F2B66506B7459/verify/lookup.json?receptor='.$mobile.'&token='.$token.'&template='.$template;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        curl_close ($ch);
    }

}

?>