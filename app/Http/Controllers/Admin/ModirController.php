<?php

namespace App\Http\Controllers\Admin;

use App\Hozeh;
use App\Modir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Excel;

class ModirController extends Controller
{
    public function index()
    {
        $modirs = Modir::all();
        $navbar = ['name' => 'حوزه ها', 'description' => 'مدیریت حوزه ها'];
        return view('admin.modir.index',['navbar' => $navbar, 'modirs' => $modirs]);
    }


    public function upload()
    {
        $navbar = ['name' => 'حوزه ها', 'description' => 'بروزرسانی حوزه ها'];
        return view('admin.modir.upload', ['navbar' => $navbar]);
    }


    public function fileUploadModir(Request $request)
    {
//        $imageName = request()->file->getClientOriginalName();
//        request()->file->move(public_path('upload'), $imageName);
//        return response()->json(['uploaded' => '/upload/'.$imageName]);

        Validator::make($request->all(), [
            'excel' => 'required'
        ])->validate();

        //Check file excel hozeh
        set_time_limit(3000);
        $pathHozeh = $request->file('excel')->getRealPath();
        $headerRowHozeh = (((Excel::load($pathHozeh))->all())->first()->keys())->toArray();
        foreach ($headerRowHozeh as $key => $valueH) {
            $fieldsH[] = ['name' => $valueH, 'type' => 'string'];
        }
        $k = 0;
        foreach ($fieldsH as $name_columnH) {
            if (
                $name_columnH['name'] == "name"
                || $name_columnH['name'] == "mobile"
                || $name_columnH['name'] == "personnel_code"
            ) {
                $k = $k + 1;
            }
        }

        //End

        if ($k == 3) {
            Excel::load($request->file('excel')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $rowModir) {
                    $modir['name'] = $rowModir['name'];
                    $modir['mobile'] = $rowModir['mobile'];
                    $modir['personnel_code'] = $rowModir['personnel_code'];
                    $modir['updated_at'] = now();
                    if (!empty($modir)) {
                        $exist = Modir::where('personnel_code', $rowModir['personnel_code'])->first();
                        if ($exist != null) {
                            Modir::whereId($exist->id)->update($modir);
                        } else {
                            $modir['created_at'] = now();
                            Modir::insert($modir);
                        }
                    }
                }
            });
            alert()->success('بروزرسانی شد', '');
            return redirect('/admin/modir');
        }
        alert()->error('خطا', 'اکسل بارگزاری شده با تمپلیت سایت تطابق ندارد');
        return back();
    }
}
