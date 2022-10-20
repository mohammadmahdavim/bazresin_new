<?php

namespace App\Http\Controllers\Admin;

use App\Bazres;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Excel;

class InspectorController extends Controller
{
    public function index()
    {
        $modirs = Bazres::all();
        $navbar = ['name' => 'بازرس ها', 'description' => 'مدیریت بازرس ها'];
        return view('admin.inspector.index',['navbar' => $navbar, 'modirs' => $modirs]);
    }


    public function upload()
    {
        $navbar = ['name' => 'بازرس ها', 'description' => 'بروزرسانی بازرس ها'];
        return view('admin.inspector.upload', ['navbar' => $navbar]);
    }


    public function fileUploadInspector(Request $request)
    {

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
                || $name_columnH['name'] == "codemeli"
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
                    $modir['codemeli'] = $rowModir['codemeli'];
                    $modir['updated_at'] = now();
                    if (!empty($modir)) {
                        $exist = Bazres::where('codemeli', $rowModir['codemeli'])->first();
                        if ($exist != null) {
                            Bazres::whereId($exist->id)->update($modir);
                        } else {
                            $modir['created_at'] = now();
                            Bazres::insert($modir);
                        }
                    }
                }
            });
            alert()->success('بروزرسانی شد', '');
            return redirect('/admin/inspector');
        }
        alert()->error('خطا', 'اکسل بارگزاری شده با تمپلیت سایت تطابق ندارد');
        return back();
    }
}
