<?php

namespace App\Http\Controllers\User;

use App\lib\EnConverter;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $navbar = ['name' => 'پروفایل', 'description' => 'ویرایش پروفایل'];
        $user = User::find(auth()->user()->id);
        return view('user.profile.index', ['navbar' => $navbar, 'user' => $user]);
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if ($request->hasFile('avatar')) {

            //For delete Image in public folder
            if ($user->avatar != "man.png" || $user->avatar != "woman.png") {
                $image_path = public_path() . 'assets/images/user_image/' . $user->avatar;
                unlink($image_path);
            }
            //End delete Image

            //Save Image New
            $image = $request->file('avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200, 200);
//            $image_resize->insert('assets/watermark.png','bottom-left',10,10);
            $image_resize->save(public_path('assets/images/user_image//' . $filename));
            $user->avatar = $filename;
            //End save Image
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        if ($user->update()) {
            alert()->success('موفق', 'عملیات با موفقیت انجام شد');
            return back();
        } else {
            alert()->error('خطا', 'لطفا دوباره سعی نمایید');
            return back();
        }

    }

    public function setting(Request $request)
    {
        $data = $request->all();
        if($data['password2fa'] != null){
            Validator::make($request->all(),[
                'password2fa' => 'min:4'
            ])->validate();
        }

        $password = EnConverter::bn2en($data['password']);
        $password2fa = EnConverter::bn2en($data['password2fa']);
        $user = User::find(auth()->user()->id);
        if($data['password2fa'] != null && $data['password'] == null){
            $user->update([
                'token_2fa' => $password2fa
            ]);
            alert()->success('موفق','عملیات با موفقیت انجام شد');
            return back();
        }


        $validator = Validator::make($request->all(), [
            'password_current' => 'required',
            'password' => 'min:6|confirmed|different:password_current',
        ])->validate();


        if (Hash::check($request->password_current, $user->password)) {
            $user->fill([
                'password' => Hash::make($password),
                'token_2fa' => $password2fa
            ])->save();

            alert()->success('موفق','عملیات با موفقیت انجام شد');
            return back();

        } else {
            alert()->error('خطا','رمز عبور قبلی شما به درستی وارد نشده است');
            return back();
        }
    }
}
