<?php

namespace App\Http\Controllers\User;

use App\Arrangement;
use App\Charts\PoshtibanPerformance;
use App\DetailsIar;
use App\Exam;
use App\FormIAR;
use App\lib\EnConverter;
use App\Mark;
use App\Modir;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Excel;

class ReportController extends Controller
{
    public function index()
    {
        $navbar = ['name' => 'گزارش', 'description' => 'گزارش بازرسی'];
        return view('user.report.index', [
            'navbar' => $navbar
        ]);
    }

    public function modir(Request $request)
    {
        $navbar = ['name' => 'گزارش مدیران', 'description' => 'گزارش آزمون محور'];
        $exams = Exam::latest()->get();
        $zones = Arrangement::select('zone')->groupBy('zone')->get();

        $filters = $request->all();

        $modirs = Arrangement::orderby('id', 'desc');
        foreach (array_keys($filters) as $filter) {
            if ($filter == 'exam_id') {
                $modirs->whereIn('exam_id', $request->$filter);
            }

            if ($filter == 'zones') {
                $modirs->whereIn('zone', $request->$filter);
            }

            if ($filter == 'modir_name') {
                $modirs->where('modir', 'LIKE', '%' . EnConverter::fa2ar($request->$filter) . '%');
            }
        }
        $modirs = $modirs->get();

        $currentQueries = $request->query();
        $url = $request->fullUrlWithQuery($currentQueries);
        $url = explode('?', $url)[1];

        if ($request->ajax()) {
            return view('user.include.modir', [
                'navbar' => $navbar,
                'exams' => $exams,
                'zones' => $zones,
                'modirs' => $modirs,
                'filters' => $filters,
                'url' => $url
            ])->render();
        }

        if (!isset($request->exam_id)) {
            $modirs = [];
        }

        return view('user.report.modir', [
            'navbar' => $navbar,
            'exams' => $exams,
            'zones' => $zones,
            'modirs' => $modirs,
            'filters' => $filters,
            'url' => $url
        ]);
    }


    public function modirReport($exam_id, $modir_code)
    {
        $navbar = ['name' => 'گزارش', 'description' => 'گزارش بازرسی'];
        $modirs = DB::table('exam' . $exam_id)->where('modir_code', $modir_code)->get();
        return view('user.report.report', [
            'navbar' => $navbar,
            'modirs' => $modirs,
            'exam_id' => $exam_id
        ]);
    }

    public function reportPoshtiban($exam_id, $codemeli)
    {
        $navbar = ['name' => 'گزارش', 'description' => 'گزارش پشتیبان'];
        $report = DB::table('exam' . $exam_id)->where('poshtiban_code', $codemeli)->first();
        $mark = Mark::where('poshtiban_code', $codemeli)->where('exam_id', $exam_id)->first();
        return view('user.report.poshtiban', [
            'navbar' => $navbar,
            'report' => $report,
            'mark' => $mark,
            'exam_id' => $exam_id,
        ]);
    }


    public function downloadExcel(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->exam_id)) {
                if (!isset($request->zones)) {
                    return response()->json(['error' => 'هیچ منطقه ای انتخاب نشده است.', 'status' => 400]);
                }

            } else {
                return response()->json(['error' => 'هیچ آزمونی انتخاب نشده است.', 'status' => 400]);
            }
            return response()->json(['message' => 'در حال تولید گزارش...', 'status' => 200]);
        } else {
            $exams = $request->exam_id;
            foreach ($exams as $exam) {
                $datas = DB::table('exam' . $exam)
                    ->whereIn('zone', $request->zones)
                    ->groupBy('modir_code')
                    ->get();
                $ex_array = [];
                foreach ($datas as $data) {
                    $ex_array[] = array(
                        'آزمون' => Exam::find($exam)->name,
                        'منطقه' => $data->zone,
                        'حوزه' => $data->name_hozeh,
                        'مدیر حوزه' => $data->modir,
                        'تعداد مدیر در حوزه' => Exam::numberModir($exam, $data->modir_code),
                        'تعداد پشتیبان در حوزه' => Exam::numberPoshtiban($exam, $data->modir_code),
                        'کل تحت پوشش' => Exam::totalStudent($exam, $data->modir_code),
                        'کنکوری' => Exam::totalKonkur($exam, $data->modir_code),
                        'پایه' => Exam::totalPayeh($exam, $data->modir_code),
                        'دبستان' => Exam::totalDabestan($exam, $data->modir_code),
                        'هنرستان' => Exam::totalHonarestan($exam, $data->modir_code),
                        'سرگروه' => Exam::sarGroup($exam, $data->modir_code),
                        'بازرس' => $data->bazres_name,
                        'درصد حضور' => Exam::Hozor($exam, $data->modir_code) . '%',
                        'درصد دفتر برنامه ریزی' => Exam::Barnameh($exam, $data->modir_code) . '%',
                        'درصد کتاب خود آموز' => Exam::Khodamoz($exam, $data->modir_code) . '%',
                        'درصد کتاب تابستان' => Exam::Book($exam, $data->modir_code) . '%',
                        'تخته نویسی' => Exam::Takhteh($exam, $data->modir_code, Exam::numberPoshtiban($exam, $data->modir_code)) . '%',
                        'خودنگاری' => Exam::Khodnegari($exam, $data->modir_code) . '%',
                        'رفع اشکال' => Exam::RafeEshkal($exam, $data->modir_code, Exam::numberPoshtiban($exam, $data->modir_code)) . '%',
                        'نمره بازرس' => Exam::Mark($exam, $data->modir_code),
                    );
                }
            }


            return Excel::create('report', function ($excel) use ($ex_array) {
                $excel->sheet('jambandi', function ($sheet) use ($ex_array) {
                    $sheet->fromArray($ex_array);
                });
            })->download('xlsx');
        }
    }


    public function downloadExcelItemIar(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->exam_id)) {
                if (!isset($request->zones)) {
                    return response()->json(['error' => 'هیچ منطقه ای انتخاب نشده است.', 'status' => 400]);
                }

            } else {
                return response()->json(['error' => 'هیچ آزمونی انتخاب نشده است.', 'status' => 400]);
            }
            return response()->json(['message' => 'در حال تولید گزارش...', 'status' => 200]);
        } else {
            $exams = $request->exam_id;
            $ex_array = [];
            foreach ($exams as $exam) {
                $datas = DB::table('exam' . $exam)
                    ->whereIn('zone', $request->zones)
                    ->groupBy('modir_code')
                    ->get();


                foreach ($datas as $data) {

                    $modirIar = FormIAR::where('modir_code', $data->modir_code)->where('exam_id', $exam)->first();
                    if ($modirIar != null) {
                        $details = DetailsIar::where('iar_id', $modirIar->id)->get();

                        foreach ($details as $detail) {
                            $ex_array[] = array(
                                'آزمون' => Exam::find($exam)->name,
                                'منطقه' => $data->zone,
                                'حوزه' => $data->name_hozeh,
                                'مدیر حوزه' => $data->modir,
                                'بازرس' => $data->bazres_name,
                                'آیتم' => Modir::getQuestion($detail->question_id),
                                'نمره' => $detail->mark,
                                'توضیحات' => Modir::getGozineh($detail->description),
                            );
                        }
                    }

                }
            }


            return Excel::create('report', function ($excel) use ($ex_array) {
                $excel->sheet('reportIar', function ($sheet) use ($ex_array) {
                    $sheet->fromArray($ex_array);
                });
            })->download('xlsx');
        }
    }


    public function downloadPdf(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->exam_id)) {
                if (!isset($request->zones)) {
                    return response()->json(['error' => 'هیچ منطقه ای انتخاب نشده است.', 'status' => 400]);
                }

            } else {
                return response()->json(['error' => 'هیچ آزمونی انتخاب نشده است.', 'status' => 400]);
            }
            return response()->json(['message' => 'در حال تولید گزارش...', 'status' => 200]);
        } else {
            $exams = $request->exam_id;

//            foreach ($exams as $exam) {
//                foreach (Mark::where('exam_id',$exam)->groupBy('poshtiban_code')->get() as $mark){
//                    $data = DB::table('exam'.$exam)->where('poshtiban_code',$mark->poshtiban_code)->first();
//                    if($data != null){
//                        Mark::where('exam_id',$exam)->where('poshtiban_code',$mark->poshtiban_code)->update(['modir_code' => $data->modir_code]);
//                    }
//                }
//            }
//
//            return 'ok';


            foreach ($exams as $exam) {
                $datas = DB::table('exam' . $exam)
                    ->whereIn('zone', $request->zones)
                    ->groupBy('modir_code')
                    ->pluck('modir_code')
                    ->toArray();
                $modirs[$exam] = $datas;
            }
            foreach ($modirs as $modir) {
                foreach ($modir as $single) {
                    $allmodir[] = $single;
                }
            }

            return view('user.report.pdf', [
                'modirs' => array_unique($allmodir),
                'exams' => $exams,
            ]);
        }
    }
}
