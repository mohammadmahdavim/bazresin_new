<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\VerifyModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\lib\EnConverter;
use App\lib\SendSms;
use Auth;
use jDate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|melli_code|unique:users',
            'mobile' => 'unique:users|iran_mobile|required',
            'first_name' => 'required|persian_alpha',
            'last_name' => 'required|persian_alpha',
            'password' => 'required|string|min:6|confirmed',
            'sex' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $mobile=EnConverter::bn2en($data['mobile']);
        $password = EnConverter::bn2en($data['password']);
        $token = rand(10000,99999);
        $template='RegisterGhalamchi';
        $date = jDate::forge()->format('date');
        $send = SendSms::send($mobile,$token,$template);
        $user = User::create([
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'codemeli' => (int)$data['username'],
            'mobile' => $mobile,
            'password' => Hash::make($password),
            'role' => 4,
            'avatar' => $data['sex'].'.png',
            'api_token' => str_random(50),
            'sex' => $data['sex'],
            'verification' => 1,
        ]);
        $verify = VerifyModel::create([
            'mobile' => $mobile,
            'code'  => $token,
            'date'  => $date,
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
