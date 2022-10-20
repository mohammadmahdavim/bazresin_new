<?php

namespace App\Http\Controllers\Auth;

use App\Bazres;
use App\User;
use App\VerifyModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\jDate;

class VerifyController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }

    /**
     * Verify sms to authentication user mobile
     * 1397-11-09
     * author : M-Fakhrani
     */

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:5',
        ]);

        if ($validator->fails()) {
            alert()->error('خطا','کد را به درستی وارد نمایید!')->autoClose();
            return redirect()->back();
        }

        $date = jDate::forge()->format('date');
        $verify = VerifyModel::where('date',$date)->where('code',$request->code)->orderby('id','desc')->first();
        if(!empty($verify) && $verify->user_id == auth()->user()->id){
            $verification = User::where('mobile',$verify->mobile)->update(['verification' => 'yes']);
            $bazres = Bazres::where('codemeli', auth()->user()->codemeli)->first();
            if($bazres != null){
                User::where('mobile',$verify->mobile)->update(['role' => 'bazres']);
            }
            return redirect('/');
        }
        alert()->error('خطا','کد وارد شده صحیح نیست')->autoClose(6000);
        return back();
    }
}
