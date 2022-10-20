<?php

namespace App\Http\Controllers\User;

use App\Arrangement;
use App\BazresHistory;
use App\DetailsIar;
use App\Exam;
use App\FormIAR;
use App\Hozeh;
use App\Http\Controllers\Controller;
use App\Mark;
use App\PoshtibanHistory;
use App\QuestionIar;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\jDate;
use Excel;
use Khill\Lavacharts\Lavacharts;

class AzmoonController extends Controller
{
    public function index()
    {

        $navbar = ['name' => 'آزمون ها', 'description' => 'آزمون های فعال'];
        $exams = Exam::where('status', 1)->orderby('id', 'desc')->paginate(6);

        return view('user.azmoon.index', ['exams' => $exams, 'navbar' => $navbar]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'modir_poshtiban_code' => 'required',
            'poshtiban' => 'required',
            'poshtiban_code' => 'required|melli_code',
            'total_student' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        // Initial data
        $exam_id = $request->exam_id;
        $modir_poshtiban_code = $request->modir_poshtiban_code;
        $poshtiban = $request->poshtiban;
        $poshtiban_code = ltrim($request->poshtiban_code, '0');;
        $total_student = $request->total_student;
        // End

        $data = DB::table('exam' . $exam_id)->where('modir_poshtiban_code', $modir_poshtiban_code)
            ->first();
        $save = DB::table('exam' . $exam_id)->insert([
            'bazres' => auth()->user()->codemeli,
            'date' => jDate::forge()->format('datetime'),
            'status' => 0,
            'condition' => '',
            'type' => 1,
            'modir' => $data->modir,
            'modir_mobile' => $data->modir_mobile,
            'modir_code' => $data->modir_code,
            'bazres_name' => $data->bazres_name,
            'bazres_code' => $data->bazres_code,
            'zone' => $data->zone,
            'name_hozeh' => $data->name_hozeh,
            'modir_poshtiban' => $data->modir_poshtiban,
            'modir_poshtiban_code' => $data->modir_poshtiban_code,
            'poshtiban' => $poshtiban,
            'poshtiban_code' => $poshtiban_code,
            'total_student' => $total_student
        ]);

        if ($save) {
            $id = DB::getPdo()->lastInsertId();
            return response()->json(['messages' => ['row_id' => $id]]);
        }
        return response()->json(['errors' => ['خطایی در ذخیره سازی رخ داد']]);
    }

    public function show($id)
    {
        $azmoon = Exam::find($id);
        $navbar = ['name' => $azmoon->name, 'description' => $azmoon->date];
        $records = DB::table('exam' . $id)->where('bazres_code', auth()->user()->codemeli)->get();
        $modir_codes = DB::table('exam' . $id)
            ->where('bazres_code', auth()->user()->codemeli)
            ->pluck('modir_poshtiban', 'modir_poshtiban_code')
            ->toArray();
        return view('user.azmoon.show', ['records' => $records, 'navbar' => $navbar, 'azmoon' => $azmoon, 'modir_codes' => $modir_codes]);
    }


    public function edit($azmoon_id, $id)
    {
        $navbar = ['name' => 'آزمون ها', 'description' => 'آزمون های فعال'];
        $azmoon = Exam::find($azmoon_id);
        $data = DB::table('exam' . $azmoon_id)->find($id);
        $histories = PoshtibanHistory::where('poshtiban_code', $data->poshtiban_code)
            ->orderby('id', 'desc')
            ->get();
        $header = DB::table('exam' . $azmoon_id)->where('type', 2)->first();

        $mean = Mark::where('poshtiban_code',$data->poshtiban_code)->orderBy('id','desc')->take(7);
        $tooltip = [
            'exams' => $mean->count(),
            'card' => $mean->avg('card'),
            'card0mark' => '2',
            'hozor_ontime' => $mean->avg('hozor_ontime'),
            'hozor_ontime0mark' => '1',
            'form_bazresi' => $mean->avg('form_bazresi'),
            'form_bazresi0mark' => '1',
            'num_barnameh' => $mean->avg('num_barnameh'),
            'num_barnameh0mark' => '3',
            'num_khodamoz' => $mean->avg('num_khodamoz'),
            'num_khodamoz0mark' => '3',
            'num_book_tabestan' => $mean->avg('num_book_tabestan'),
            'num_book_tabestan0mark' => '3',
            'takhteh_nevisi' => $mean->avg('takhteh_nevisi'),
            'takhteh_nevisi0mark' => '1',
            'rafe_eshkal' => $mean->avg('rafe_eshkal'),
            'rafe_eshkal0mark' => '2',
            'num_khodnegari' => $mean->avg('num_khodnegari'),
            'num_khodnegari0mark' => '2',
            'quality_face' => $mean->avg('quality_face'),
            'quality_face0mark' => '2',
            'extera_mark' => $mean->avg('extera_mark'),
            'extera_mark0mark' => '2'
        ];

        $all_exam =  $mean->count();
        $losses = [
            'exams' => $all_exam,
            'card' => (($all_exam * 2)- $mean->sum('card')),
            'hozor_ontime' => (($all_exam * 1) - $mean->sum('hozor_ontime')),
            'form_bazresi' => (($all_exam * 1) - $mean->sum('form_bazresi')),
            'num_barnameh' => (($all_exam * 3) - $mean->sum('num_barnameh')),
            'num_khodamoz' => (($all_exam * 3) - $mean->sum('num_khodamoz')),
            'num_book_tabestan' => (($all_exam * 3) - $mean->sum('num_book_tabestan')),
            'takhteh_nevisi' => (($all_exam * 1) - $mean->sum('takhteh_nevisi')),
            'rafe_eshkal' => (($all_exam * 2) - $mean->sum('rafe_eshkal')),
            'num_khodnegari' => (($all_exam * 2) - $mean->sum('num_khodnegari')),
            'quality_face' => (($all_exam * 2) - $mean->sum('quality_face')),
        ];

        $translates = [
            'card' => 'کارت شناسایی',
            'hozor_ontime' => 'حضور به موقع دانش آموزان',
            'form_bazresi' => 'فرم بازرسی',
            'takhteh_nevisi' => 'تخته نویسی',
            'num_barnameh' => 'کتاب برنامه ریزی',
            'num_khodamoz' => 'کتاب خود آموز',
            'num_book_tabestan' => 'کتاب کمک درسی',
            'rafe_eshkal' => 'کلاس رفع اشکال',
            'num_khodnegari' => 'خودنگاری',
            'quality_face' => 'ظاهر آموزشی',
        ];

        $old = Mark::where('poshtiban_code',$data->poshtiban_code)->orderBy('id','desc')->whereNotIn('exam_id',[$azmoon_id])->first();

        if (strpos($data->bazres_code, auth()->user()->codemeli) !== false) {
            $count = DB::table('exam' . $azmoon_id)->where('type', '3')->count();
            $limit = $count - 1;
            $select = DB::table('exam' . $azmoon_id)->where('type', '3')->take($limit)->get();
            $type_select = DB::table('exam' . $azmoon_id)->orderby('id', 'asc')->take(1)->get();
            return view('user.azmoon.edit', ['translates' => $translates,'losses' => $losses,'old' => $old,'tooltip' => $tooltip,'histories' => $histories, 'data' => $data, 'azmoon' => $azmoon, 'type_select' => $type_select, 'select' => $select, 'header' => $header, 'navbar' => $navbar]);
        } else {
            alert()->error('خطا', 'شما مجاز نیستید');
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        // Check state in project
        $proj = 'exam' . $request->azmoon_id;
        $isColExist = Schema::connection('mysql')->hasColumn($proj, 'mark');
        if ($isColExist == false) {
            Schema::table($proj, function ($table) {
                $table->tinyInteger('mark')->after('disadvantages')->default(0);
            });
            DB::table($proj)->where('type', 2)->limit(1)->update(['mark' => 'نمره']);
            DB::table($proj)->where('id', 1)->limit(1)->update(['mark' => 0]);
        }
        // End

        if ($request->vaziat == 1) {
            $table = 'exam' . $request->azmoon_id;
            $required = DB::table($table)
                ->where('type', 4)->first();

            if ($required != null) {
                $columns = DB::getSchemaBuilder()->getColumnListing($table);
                $empty = array();
                foreach ($columns as $column) {
                    if ($required->$column == 1) {
                        if ($request->$column == null) {
                            $empty[] = DB::table($table)->where('type', 2)->first()->$column;
                        }
                    }
                }
                if (count($empty) != 0) {
                    return response()->json(['errors' => $empty, 'status' => 401]);
                }
            }

            if($request->rafe_eshkal == 'دارد'){
                if($request->dars_rafe_eshkal == null){
                    return response()->json(['errors' => ['درس رفع اشکال بایستی پر گردد'], 'status' => 401]);
                }
                if($request->number_student_rafe_eshkal == 0){
                    return response()->json(['errors' => ['تعداد دانش آموزان حاضر در کلاس رفع اشکال درج نشده است'], 'status' => 401]);
                }
            }
        }
        if( $request->vaziat == 3 || $request->vaziat == 4){
            if($request->hozor_ontime == 0){
                return response()->json(['errors' => ['آمار حضور دانش آموزان حتما باید ثبت گردد.'], 'status' => 401]);
            }
        }



        $sabt = DB::table('exam' . $request->azmoon_id)->where('id', $id);
        $row = DB::table('exam' . $request->azmoon_id)->find($id);

        $date = jDate::forge()->format('datetime');
        $user = User::find(auth()->user()->id);
        $bazres = auth()->user()->codemeli;
        $poshtiban = DB::table('exam' . $request->azmoon_id)->find($id)->poshtiban_code;

        if ($poshtiban == null) {
            $poshtiban = 'exam_' . $request->azmoon_id . '_' . $id;
        }

        // Check Vaziat Bazresi
        if ($request->vaziat == 1) {
            $condition = "موفق";
        } elseif ($request->vaziat == 2) {
            $condition = "بازدید مجدد";
        } elseif ($request->vaziat == 3) {
            $condition = "غائب";
        } elseif ($request->vaziat == 4) {
            $condition = "قطع همکاری";
        } else {
            $condition = "نامشخص";
        }
        // End Check



        // Save Data Bazresi
        $data = $request->all();
        $count_request = count($data);
        $shomarande = 0;
        $test = array();
        foreach (array_keys($data) as $value) {
            if ($shomarande != 0 && $shomarande != 1 && $shomarande != $count_request - 1) {
                $values = $request->input($value);
                if (is_array($values)) {
                    $string = implode(' - ', $values);
                    $textCall = substr($string, 0);
                    $test[$value] = $sabt->$value = $textCall;
                } else {
                    $textCall = substr($values, 0);
                    $test[$value] = $sabt->$value = $textCall;
                }


            }
            $shomarande += 1;

        }
        $test['status'] = $request->vaziat;
        $test['condition'] = $condition;
        $test['date'] = $date;
        $test['bazres'] = $user->codemeli;



        // Save Mark
        if ($request->vaziat == 1) {

            $mark = array();

            // Card
            if ($test['card'] == 'دارد') {
                $mark['card'] = 2;
            } elseif ($test['card'] == 'ندارد') {
                $mark['card'] = 0;
            } else {
                $mark['card'] = 1;
            }
            // End

            // Hozor
            if ($test['hozor_delay'] == 0) {
                $mark['hozor_ontime'] = 1;
            } else {
                $mark['hozor_ontime'] = 0;
            }
            // End

            // Form Bazresi
            if ($test['form_bazresi'] == 'دارد و تکمیل کرده است') {
                $mark['form_bazresi'] = 1;
            } else {
                $mark['form_bazresi'] = 0;
            }
            // End

            // Takhteh Nevisi
            if ($test['takhteh_nevisi'] == 'دارد') {
                $mark['takhteh_nevisi'] = 1;
            } else {
                $mark['takhteh_nevisi'] = 0;
            }
            // End

            // Barnameh Book
            $percent_barnameh = ($test['num_barnameh'] * 100) / $request->hozor_ontime;
            if ($percent_barnameh >= 80) {
                $mark['num_barnameh'] = 3;
            } elseif ($percent_barnameh >= 50 && $percent_barnameh < 80) {
                $mark['num_barnameh'] = 2;
            } elseif ($percent_barnameh >= 20 && $percent_barnameh < 50) {
                $mark['num_barnameh'] = 1;
            } else {
                $mark['num_barnameh'] = 0;
            }
            // End


            // Khodamoz Book
            $percent_khodamoz = ($test['num_khodamoz'] * 100) / $request->hozor_ontime;
            if ($percent_khodamoz >= 80) {
                $mark['num_khodamoz'] = 3;
            } elseif ($percent_khodamoz >= 50 && $percent_khodamoz < 80) {
                $mark['num_khodamoz'] = 2;
            } elseif ($percent_khodamoz >= 20 && $percent_khodamoz < 50) {
                $mark['num_khodamoz'] = 1;
            } else {
                $mark['num_khodamoz'] = 0;
            }
            // End


            // Tabestan Book
            $percent_book_tabestan = ($test['num_book_tabestan'] * 100) / $request->hozor_ontime;
            if ($percent_book_tabestan >= 20) {
                $mark['num_book_tabestan'] = 3;
            } elseif ($percent_book_tabestan >= 10 && $percent_book_tabestan < 20) {
                $mark['num_book_tabestan'] = 2;
            } elseif ($percent_book_tabestan >= 1 && $percent_book_tabestan < 10) {
                $mark['num_book_tabestan'] = 1;
            } else {
                $mark['num_book_tabestan'] = 0;
            }
            // End


            // Rafe Eshkal
            $percent_rafe_eshkal = ($test['number_student_rafe_eshkal'] * 100) / $request->hozor_ontime;
            if ($percent_rafe_eshkal >= 20) {
                $mark['rafe_eshkal'] = 2;
            } elseif($percent_rafe_eshkal > 0 && $percent_rafe_eshkal < 20){
                $mark['rafe_eshkal'] = 1;
            } else {
                $mark['rafe_eshkal'] = 0;
            }
            // End


            // Khodnegari
            $percent_khodnegari = ($test['num_khodnegari'] * 100) / $request->hozor_ontime;
            if ($percent_khodnegari >= 20) {
                $mark['num_khodnegari'] = 2;
            } elseif($percent_khodnegari > 0 && $percent_khodnegari < 20){
                $mark['num_khodnegari'] = 1;
            } else {
                $mark['num_khodnegari'] = 0;
            }
            // End


            // Quality Face
            if($test['quality_face'] == 'کاملا موجه و رسمی'){
                $mark['quality_face'] = 2;
            } elseif($test['quality_face'] == 'موجه') {
                $mark['quality_face'] = 1;
            } else {
                $mark['quality_face'] = 0;
            }
            // End

            // Extera Mark
            if(isset($test['extera_mark'])){
                $mark['extera_mark'] = $test['extera_mark'];
            } else {
                $mark['extera_mark'] = 0;
            }
            // End

            // Information
                $mark['bazres_code'] = $bazres;
                $mark['poshtiban_code'] = $poshtiban;
                $mark['modir_code'] = $row->modir_poshtiban_code;
                $mark['exam_id'] = $request->azmoon_id;
            // End


            // Total
                $total = $mark['card'] +
                    $mark['hozor_ontime'] +
                    $mark['form_bazresi'] +
                    $mark['takhteh_nevisi'] +
                    $mark['num_barnameh'] +
                    $mark['num_khodamoz'] +
                    $mark['num_book_tabestan'] +
                    $mark['rafe_eshkal'] +
                    $mark['num_khodnegari'] +
                    $mark['quality_face'] +
                    $mark['extera_mark'];

                if($total > 20){
                    $mark['total'] = 20;
                } else {
                    $mark['total'] = $total;
                }
            // End


            $check = Mark::where('exam_id', $request->azmoon_id)
                ->where('poshtiban_code',$poshtiban)->first();
                if($check == null){
                    Mark::create($mark);
                } else {
                    $check->update($mark);
                }
        }
        // End Mark


        if ($request->vaziat == 1) {
            // Check history
            $history = PoshtibanHistory::where('poshtiban_code', $poshtiban)
                ->where('exam_id', $request->azmoon_id)->first();

            $targets = (in_array('targeting', array_keys($request->all())) ? implode(',', $request->targeting) : null);
            $debility = (in_array('disadvantages', array_keys($request->all())) ? implode(',', $request->disadvantages) : null);
            if ($history == null) {
                PoshtibanHistory::create([
                    'exam_id' => $request->azmoon_id,
                    'targets' => $targets,
                    'debility' => $debility,
                    'quality_face' => $mark['quality_face'],
                    'quality_performance' => $total,
                    'quality_face_mark' => $mark['quality_face'],
                    'quality_performance_mark' => $total,
                    'date' => jDate::forge()->format('datetime'),
                    'poshtiban_code' => $poshtiban,
                    'bazres_code' => $bazres
                ]);
            } else {
                $history->update([
                    'targets' => $targets,
                    'debility' => $debility,
                    'quality_face' => $mark['quality_face'],
                    'quality_performance' => $total,
                    'quality_face_mark' => $mark['quality_face'],
                    'quality_performance_mark' => $total,
                    'poshtiban_code' => $poshtiban,
                    'bazres_code' => $bazres
                ]);
            }
            // End
        }

        $test['mark'] = (isset($total) ? $total : 0);
        if ($sabt->update($test)) {
            return response()->json(['messages' => 'با موفقیت ذخیره شد', 'status' => 200]);
        } else {
            return response()->json(['messages' => 'حین ورود اطلاعات خطایی رخ داد. دوباره امتحان کنید', 'status' => 401]);
        }
        //End save
    }


    public function bazresi(Request $request)
    {
        $id = $request->azmoon_id;
        return $this->choice($id);
    }


    public function choice($id)
    {
        $azmoon = Exam::find($id);
        $navbar = ['name' => $azmoon->name, 'description' => $azmoon->date];
        return view('user.azmoon.choice', ['navbar' => $navbar, 'azmoon' => $azmoon]);
    }


    public function modir($id)
    {
        $azmoon = Exam::find($id);
        $navbar = ['name' => $azmoon->name, 'description' => $azmoon->date];
        $record = DB::table('exam' . $id)->where('bazres_code', auth()->user()->codemeli)->pluck('modir', 'modir_code')->toArray();
        $records = array_unique($record);
        return view('user.azmoon.modir', ['navbar' => $navbar, 'records' => $records, 'azmoon' => $azmoon]);
    }

    public function iar($exam_id, $modir_code)
    {
        $navbar = ['name' => 'ارزیابی مدیر', 'description' => 'فرم IAR'];
        $hozeh = Arrangement::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        $questions = QuestionIar::where('status', 1)->get();
        $iar = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        alert()->warning('توجه', 'بازرس محترم، تمام فیلد ها بایستی پر شوند تا در سامانه به درستی ثبت گردند و گرنه در حالت لطفا صبر کنید باقی خواهد ماند.')->autoClose(15000);
        return view('user.azmoon.iar', [
            'navbar' => $navbar,
            'questions' => $questions,
            'modir_code' => $modir_code,
            'exam_id' => $exam_id,
            'hozeh' => $hozeh,
            'iar' => $iar,
        ]);
    }


    public function iarSave(Request $request)
    {
        // Initial Data
        $data = $request->all();
        $bazres_code = auth()->user()->codemeli;
        $modir_code = $data['modir_code'];
        $exam_id = $data['exam_id'];
        $hozeh_code = $data['hozeh_code'];
        // End


        $nulls = array();
        foreach ($data as $key => $value) {
            if ($value == null) {
                $nulls[] = $key;
            }
        }


        if (count($nulls) != 0) {
            return 'nulls';
        }

        $shomarande = 0;
        $test = array();
        foreach (array_keys($data) as $value) {
            if ($shomarande != 0 && $shomarande != 1 && $shomarande != 2 && $shomarande != 3) {
                $values = $request->input($value);
                if (is_array($values)) {
                    $string = implode(' - ', $values);
                    $textCall = substr($string, 0);
                    $test[$value] = $textCall;
                } else {
                    $textCall = substr($values, 0);
                    $test[$value] = $textCall;
                }


            }
            $shomarande += 1;

        }


        $newArray = [];
        foreach ($test as $key => $value) {
            list($keyName, $keyNumber) = sscanf($key, 'item%[A-Za-z]%d');
            if (!is_null($keyNumber)) {
                $newArray[$keyNumber]['item' . $keyName] = $value;
            }
        }


        $check = FormIAR::where('exam_id', $exam_id)->where('modir_code', $modir_code)->first();
        if (!$check) {
            $iar_id = FormIAR::create([
                'modir_code' => $modir_code,
                'bazres_code' => $bazres_code,
                'exam_id' => $exam_id,
                'hozeh_code' => $hozeh_code,
                'status' => 0,
                'date' => jDate::forge()->format('datetime'),
                'mark' => 2,
                'img_signature' => ''
            ])->id;


            foreach ($newArray as $key => $single) {
                DetailsIar::create([
                    'iar_id' => $iar_id,
                    'question_id' => $key,
                    'description' => $single['itemDesc'],
                    'mark' => $single['itemMark']
                ]);
            }

            $mark = DetailsIar::where('iar_id', $iar_id)->sum('mark');
            FormIAR::where('id', $iar_id)->update(['mark' => $mark]);

        } else {

            foreach ($newArray as $key => $single) {
                DetailsIar::where('iar_id', $check->id)
                    ->where('question_id', $key)
                    ->update([
                        'description' => $single['itemDesc'],
                        'mark' => $single['itemMark']
                    ]);
            }

            $mark = DetailsIar::where('iar_id', $check->id)->sum('mark');

            $check->update([
                'modir_code' => $modir_code,
                'bazres_code' => $bazres_code,
                'exam_id' => $exam_id,
                'hozeh_code' => $hozeh_code,
                'status' => 2,
                'date' => jDate::forge()->format('datetime'),
                'mark' => $mark,
                'img_signature' => ''
            ]);
        }


        return response()->json(['messages' => 'با موفقیت ذخیره شد']);
    }

    public function iarSubmit($exam_id, $modir_code)
    {
        $navbar = ['name' => 'امضای مدیرحوزه', 'description' => 'تایید نهایی مدیرحوزه'];
        $hozeh = Arrangement::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        $iar = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        $answers = DetailsIar::where('iar_id', $iar->id)->get();
        return view('user.azmoon.iar.signature', [
            'navbar' => $navbar,
            'modir_code' => $modir_code,
            'exam_id' => $exam_id,
            'hozeh' => $hozeh,
            'answers' => $answers,
            'iar' => $iar
        ]);
    }

    public function iarSaveSignature(Request $request)
    {

        // Get data Form Iar
        parse_str($request->formIar, $formdata);//This will convert the string to array

        $modir_ghayeb = (in_array('modir_ghayeb', array_keys($formdata)) ? implode(',', $formdata['modir_ghayeb']) : null);
        $modir_moteakher = (in_array('modir_moteakher', array_keys($formdata)) ? implode(',', $formdata['modir_moteakher']) : null);
        $poshtiban_ghayeb = (in_array('poshtiban_ghayeb', array_keys($formdata)) ? implode(',', $formdata['poshtiban_ghayeb']) : null);
        $poshtiban_moteakher = (in_array('poshtiban_moteakher', array_keys($formdata)) ? implode(',', $formdata['poshtiban_moteakher']) : null);
        $poshtiban_amozeshi = (in_array('poshtiban_amozeshi', array_keys($formdata)) ? implode(',', $formdata['poshtiban_amozeshi']) : null);
        $shakhes_ghovat = (in_array('shakhes_ghovat', array_keys($formdata)) ? $formdata['shakhes_ghovat'] : null);
        $ekhtelal_nazm = (in_array('ekhtelal_nazm', array_keys($formdata)) ? $formdata['ekhtelal_nazm'] : null);
        $arzyabi = (in_array('arzyabi', array_keys($formdata)) ? $formdata['arzyabi'] : null);
        $mark_nazm = (in_array('mark_nazm', array_keys($formdata)) ? $formdata['mark_nazm'] : null);
        $mark_performance = (in_array('mark_performance', array_keys($formdata)) ? $formdata['mark_performance'] : null);
        // End

        if ($shakhes_ghovat == null || $ekhtelal_nazm == null || $arzyabi == null || $shakhes_ghovat == null || $mark_nazm == null || $mark_performance == null) {
            return response()->json(['errors' => 'آیتم های * دار بایستی کاملا پر شوند', 'status' => 400]);
        }

        // Foe modir
        $img = $request->img_signature;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = uniqid() . '.png';
        $file = public_path('assets/signature-image/' . $name);
        $success = file_put_contents($file, $data);
        $image = str_replace('/', '', $file);
        // End

        // For Bazres
        $imgBazres = $request->img_signature_bazres;
        $imgBazres = str_replace('data:image/png;base64,', '', $imgBazres);
        $imgBazres = str_replace(' ', '+', $imgBazres);
        $dataBazres = base64_decode($imgBazres);
        $nameBazres = uniqid() . '.png';
        $fileBazres = public_path('assets/signature-image/bazres/' . $nameBazres);
        $successBazres = file_put_contents($fileBazres, $dataBazres);
        $imageBazres = str_replace('/', '', $fileBazres);
        // End

        $form = FormIAR::where('exam_id', $request->exam_id)->where('modir_code', $request->modir_code)
            ->update([
                'img_signature' => $name,
                'img_signature_bazres' => $nameBazres,
                'status' => 1,
                'modir_ghayeb' => $modir_ghayeb,
                'modir_moteakher' => $modir_moteakher,
                'poshtiban_ghayeb' => $poshtiban_ghayeb,
                'poshtiban_moteakher' => $poshtiban_moteakher,
                'poshtiban_amozeshi' => $poshtiban_amozeshi,
                'shakhes_ghovat' => $shakhes_ghovat,
                'ekhtelal_nazm' => $ekhtelal_nazm,
                'arzyabi' => $arzyabi,
                'mark_nazm' => $mark_nazm,
                'mark_performance' => $mark_performance
            ]);
        if ($form) {
            return 'ok';
        } else {
            return 'fail';
        }
    }


    public function excelDownload($exam_id, $modir_code)
    {
        $check = DB::table('exam' . $exam_id)->where('modir_code', $modir_code)->first();
        if ($check != null && $check->bazres_code == auth()->user()->codemeli) {
            // for remove codemeli and...
            $table_col = DB::getSchemaBuilder()->getColumnListing('exam' . $exam_id);
            $remove = ["id", "bazres", "status", "type", "poshtiban_mobile", "modir_mobile", "poshtiban_code", "modir_code", "bazres_code"];
            $table_col = \array_diff($table_col, $remove);
            //end

            $header = DB::table("exam" . $exam_id)->where('type', 2)->select($table_col)->get()->toArray();
            $header[0]->date = 'تاریخ';
            $header[0]->condition = 'وضعیت';
            $data1 = DB::table("exam" . $exam_id)->where('type', 1)->where('modir_code', $modir_code)->select($table_col)->get()->toArray();
            $values = array_merge($header, $data1);

            $data = array();
            foreach ($values as $value) {
                $data[] = (array)$value;
            }
            return Excel::create('ExamExcel', function ($excel) use ($data) {
                $excel->sheet('mySheet', function ($sheet) use ($data) {

                    $sheet->fromArray($data, null, 'A1', false, false)->setAutoSize(false);
                    $sheet->freezeFirstRow();
                    $sheet->row(1, function ($row) {

                        // call cell manipulation methods
                        $row->setBackground('#db5762');

                    });

                });
            })->download('xlsx');
        } else {
            alert()->error('خطا', 'شما دسترسی ندارید');
            return back();
        }

    }


    public function showPdf($exam_id, $modir_code)
    {
        $data = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        $details = DetailsIar::where('iar_id', $data->id)->get();
        return view('user.azmoon.iar.print', [
            'data' => $data,
            'exam_id' => $exam_id,
            'modir_code' => $modir_code,
            'details' => $details
        ]);
    }

    public function createPdf($exam_id, $modir_code)
    {
        $data = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam_id)->first();
        $details = DetailsIar::where('iar_id', $data->id)->get();
        return view('user.azmoon.iar.pdf', [
            'data' => $data,
            'exam_id' => $exam_id,
            'modir_code' => $modir_code,
            'details' => $details
        ]);
    }


    public function logBazres($id)
    {
        $navbar = ['name' => 'لاگ بازرسی', 'description' => 'ثبت ساعت ورود و خروج بازرسی'];
        $log = BazresHistory::where('exam_id', $id)
            ->where('bazres_code', 'LIKE', '%' . auth()->user()->codemeli . '%')
            ->first();
        return view('user.azmoon.bazres.log', [
            'navbar' => $navbar,
            'log' => $log,
            'exam_id' => $id
        ]);
    }

    public function logBazresCreate(Request $request)
    {
        $log = BazresHistory::where('exam_id', $request->exam_id)
            ->where('bazres_code', 'LIKE', '%' . auth()->user()->codemeli . '%')
            ->first();
        $exam = Exam::find($request->exam_id);
        $jdate = $exam->date . ' 06:00:00';
        $carbon = \Morilog\Jalali\jDateTime::createDatetimeFromFormat('Y/m/d H:i:s', $jdate)->getTimestamp();
        $now = jDate::forge()->time();
        if ($carbon < $now) {
            if ($log == null) {
                BazresHistory::create([
                    'bazres_code' => auth()->user()->codemeli,
                    'exam_id' => $request->exam_id,
                    'start_exam' => $now
                ]);
            } else {
                $log->update([
                    'finish_exam' => $now
                ]);
            }
            return response()->json(['messages' => 'با موفقیت اعمال شد', 'status' => 200]);
        } else {
            return response()->json(['errors' => 'هنوز زمان بازرسی فرا نرسیده است.', 'status' => 401]);
        }

    }

    public function poshtibanMark(Request $request)
    {
        $mark = Mark::where('poshtiban_code',$request->codemeli)->where('exam_id',$request->exam_id)->first();
        if($mark == null){
            return response()->json(['errors' => ['سابقه ای یافت نگردید.']],400);
        }
        return view('user.azmoon.modal',[
            'mark' => $mark,
        ]);
    }
}
