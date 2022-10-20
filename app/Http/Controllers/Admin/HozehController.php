<?php

namespace App\Http\Controllers\Admin;

use App\Bazres;
use App\Exam;
use App\Hozeh;
use App\HozehModir;
use App\Modir;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Excel;

class HozehController extends Controller
{
    public function index()
    {
        $navbar = ['name' => 'حوزه ها', 'description' => 'مدیریت حوزه ها'];
        $hozeha = Hozeh::all();
        return view('admin.hozeh.index', ['navbar' => $navbar, 'hozeha' => $hozeha]);
    }


    public function upload()
    {
        $navbar = ['name' => 'حوزه ها', 'description' => 'بروزرسانی حوزه ها'];
        return view('admin.hozeh.upload', ['navbar' => $navbar]);
    }


    public function fileUploadHozeh(Request $request)
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
                $name_columnH['name'] == "code"
                || $name_columnH['name'] == "zone"
                || $name_columnH['name'] == "hozeh"
                || $name_columnH['name'] == "address"
                || $name_columnH['name'] == "num_modir"
                || $name_columnH['name'] == "num_poshtiban"
                || $name_columnH['name'] == "total_student"
                || $name_columnH['name'] == "num_konkur"
                || $name_columnH['name'] == "num_payeh"
                || $name_columnH['name'] == "num_dabestan"
                || $name_columnH['name'] == "num_honarestan"
            ) {
                $k = $k + 1;
            }
        }

        //End

        if ($k == 11) {
            Excel::load($request->file('excel')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $rowHozeh) {
                    $hozeh['zone'] = $rowHozeh['zone'];
                    $hozeh['code'] = $rowHozeh['code'];
                    $hozeh['hozeh'] = $rowHozeh['hozeh'];
                    $hozeh['address'] = $rowHozeh['address'];
                    $hozeh['num_modir'] = $rowHozeh['num_modir'];
                    $hozeh['num_poshtiban'] = $rowHozeh['num_poshtiban'];
                    $hozeh['total_student'] = $rowHozeh['total_student'];
                    $hozeh['num_konkur'] = $rowHozeh['num_konkur'];
                    $hozeh['num_payeh'] = $rowHozeh['num_payeh'];
                    $hozeh['num_dabestan'] = $rowHozeh['num_dabestan'];
                    $hozeh['num_honarestan'] = $rowHozeh['num_honarestan'];
                    $hozeh['updated_at'] = now();
                    if (!empty($hozeh)) {
                        $exist = Hozeh::where('code', $rowHozeh['code'])->first();
                        if ($exist != null) {
                            Hozeh::whereId($exist->id)->update($hozeh);
                        } else {
                            $hozeh['created_at'] = now();
                            Hozeh::insert($hozeh);
                        }
                    }
                }
            });
            alert()->success('بروزرسانی شد', '');
            return redirect('/admin/hozeh');
        }
        alert()->error('خطا', 'اکسل بارگزاری شده با تمپلیت سایت تطابق ندارد');
        return back();
    }


    public function layouts()
    {
        $navbar = ['name' => 'چیدمان حوزه ها', 'description' => 'مدیریت چیدمان حوزه ها در آزمون'];
        $exams = Exam::orderby('id', 'desc')->get();
        return view('admin.hozeh.layouts.index', ['navbar' => $navbar, 'exams' => $exams]);
    }


    public function edit($id)
    {
        $navbar = ['name' => 'چیدمان حوزه ها', 'description' => 'مدیریت چیدمان حوزه ها در آزمون'];
        $modir = DB::table('exam' . $id)
            ->whereNotNull('modir_code')
            ->where('type', 1)
            ->select('modir_code', 'name_hozeh', 'bazres_code')
            ->groupBy('modir_code')
            ->get();
        $hozeh = HozehModir::where('exam_id', $id);
        $inspectors = Bazres::whereNotIn('codemeli', $hozeh->pluck('bazres_code'))->get();
        $modirs = Modir::whereNotIn('codemeli', $hozeh->pluck('modir_code'))->get();

        return view('admin.hozeh.layouts.edit', [
            'navbar' => $navbar,
            'hozeh' => $hozeh->get(),
            'exam_id' => $id,
            'inspectors' => $inspectors,
            'modirs' => $modirs,
            'modir' => $modir
        ]);
    }

    public function ajax_arrange_exam(Request $request)
    {
        $inspector = Bazres::select('name','codemeli')->groupby('codemeli')->where('status', 1)->get();
        $hozeh = HozehModir::where('exam_id', $request->exam_id)
            ->where('bazres_code', null)
            ->get();
        return view('admin.hozeh.layouts.arrange', ['hozeh' => $hozeh, 'inspector' => $inspector]);
    }

    public function arangeUpdate(Request $request)
    {
        $exam_id = $request->exam_id;
        $modir_code = $request->modir_code;
        $hozeh = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->select('modir_code', 'name_hozeh', 'bazres_code')
            ->groupBy('name_hozeh')
            ->get();
        $inspector = Bazres::where('status', 1)->get();
        return view('admin.hozeh.layouts.arrange', [
            'exam_id' => $exam_id,
            'modir_code' => $modir_code,
            'hozeh' => $hozeh,
            'inspector' => $inspector
        ]);
    }

    public function arangeSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bazres_code' => 'required',
            'modir_code' => 'required',
            'name_hozeh' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = $request->all();

        $update = DB::table('exam' . $data['exam_id'])
            ->where('modir_code', $data['modir_code'])
            ->where('name_hozeh', $data['name_hozeh']);
        $all = count($update->get());
        $inspector = count($data['bazres_code']);

        if ($all != 0) {
            if ($inspector == 1) {
                $update->update([
                    'bazres_code' => $data['bazres_code'][0],
                    'bazres_name' => Bazres::where('codemeli', $data['bazres_code'][0])->first()->name
                ]);
            } else {
                $mid = intdiv($all, $inspector);

                foreach (array_values($data['bazres_code']) as $key => $bazres) {
                    $values = $update->skip($mid * $key)->take($mid+1)->get();
                    foreach ($values as $value) {
                        DB::table('exam' . $data['exam_id'])
                            ->where('id',$value->id)
                            ->update([
                                'bazres_code' => $bazres,
                                'bazres_name' => Bazres::where('codemeli', $bazres)->first()->name
                            ]);
                    }
                }
            }
        }
        return response()->json(['messages' => ['با موفقیت اعمال شد']]);
    }
}
