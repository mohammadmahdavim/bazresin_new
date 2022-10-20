<?php

namespace App\Http\Controllers\Admin;

use App\Arrangement;
use App\Bazres;
use App\Exam;
use App\Hozeh;
use App\HozehModir;
use App\Modir;
use App\ModirPoshtiban;
use App\Poshtiban;
use App\Zone;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Excel;
use DB;

class ExamController extends Controller
{

    public function index()
    {
        $navbar = ['name' => 'آزمون ها', 'description' => 'مدیریت آزمون ها'];
        $exams = Exam::orderby('id', 'desc')->get();
        return view('admin.exam.index', ['navbar' => $navbar, 'exams' => $exams]);
    }

    public function create()
    {
        $navbar = ['name' => 'ایجاد آزمون', 'description' => 'آپلود اکسل آزمون'];
        return view('admin.exam.create', ['navbar' => $navbar]);
    }


    public function edit($id)
    {
        $exam = Exam::find($id);
        $navbar = ['name' => 'ویرایش آزمون', 'description' => $exam->name_azmoon];
        return view('admin.exam.edit', ['navbar' => $navbar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'date' => 'required',
            'import_file' => 'required',
            'import_arrange' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        return $this->operate($request);

    }


    /*
     * author : M.Fakhrani
     * description : for create table and import data excel in database
     */


    public function operate(Request $request)
    {

        // Get Fields column Excel
        $pathP = $request->file('import_file')->getRealPath();
        $headerRowP = (((Excel::load($pathP))->all())->first()->keys())->toArray();
        foreach ($headerRowP as $key => $value) {
            $fieldExcelP[] = ['name' => $value, 'type' => 'string'];
        }

        $pathA = $request->file('import_arrange')->getRealPath();
        $headerRowA = (((Excel::load($pathA))->all())->first()->keys())->toArray();
        foreach ($headerRowA as $key => $value) {
            $fieldExcelA[] = ['name' => $value, 'type' => 'string'];
        }
        // End

        // Check item required Excel
        $fieldA = [
            'zone', 'hozeh_code', 'hozeh', 'modir', 'modir_mobile', 'modir_code'
            , 'address', 'number_modir', 'number_poshtiban', 'total', 'konkuri',
            'payeh', 'dabestan', 'honarestan', 'leader', 'leader_code', 'bazres_code', 'bazres'
        ];

        $notExistA = array();
        foreach ($fieldExcelA as $name_A) {
            if (!in_array($name_A['name'], $fieldA)) {
                $notExistA[] = $name_A['name'];
            }
        }


        $fieldP = [
            'type', 'modir', 'modir_mobile', 'modir_code', 'zone', 'name_hozeh', 'modir_poshtiban', 'modir_poshtiban_code', 'bazres_name', 'bazres_code', 'poshtiban',
            'poshtiban_code', 'total_student', 'konkur', 'payeh', 'dabestan', 'honarestan', 'card',
            'hozor_ontime', 'hozor_delay', 'form_bazresi', 'form_ghaebin', 'num_barnameh', 'num_khodamoz', 'num_book_tabestan','takhteh_nevisi',
            'rafe_eshkal', 'dars_rafe_eshkal', 'number_student_rafe_eshkal', 'num_khodnegari', 'quality_face', 'targeting', 'disadvantages', 'extera_mark','mark'
        ];

        $notExistP = array();
        foreach ($fieldExcelP as $name_P) {
            if (!in_array($name_P['name'], $fieldP)) {
                $notExistP[] = $name_P['name'];
            }
        }
        // End


        if (count($notExistP) == 0 && count($notExistA) == 0) {

            $id = Exam::create([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'date' => $request->date,
                'supervisor' => $request->supervisor,
                'description' => $request->description,
                'status' => 1
            ])->id;

            $table_name = 'exam' . $id;

            return $this->createTable($table_name, $fieldExcelP, $request, $id);

        } else {
            $log = $notExistA + $notExistP;

            response()->json(['errors' => ['این ستون ها نام شان به اشتباه در اکسل وارد شده است', $log]])->send();
            die();
        }

    }


    public function createTable($table_name, $fields = [], $request, $exam_id)
    {
        // check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {

                $table->increments('id');
                $table->string('bazres', 10)->nullable();
                $table->string('date', 20)->nullable();
                $table->tinyInteger('status')->default(0);
                $table->string('condition', 15)->nullable();
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        $table->{$field['type']}($field['name'], 255)->nullable();
                    }
                }
                $table->mediumText('comment')->nullable();
            });


            return $this->importExcel($request, $table_name, $exam_id);
        }
        return response()->json(['messages' => ['این table در دیتابیس از قبل موجود است']], 400);
    }


    public function importExcel(Request $request, $table_name, $exam_id)
    {
        set_time_limit(3000);

        if ($request->hasFile('import_file')) {
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) use ($exam_id) {
                $headerRow = (($reader->all())->first()->keys())->toArray();
                foreach ($headerRow as $key => $value) {
                    $fields[] = ['name' => $value];
                }
                foreach ($reader->toArray() as $key => $row) {
                    $data['type'] = $row['type'];
                    $data['bazres'] = "";
                    $data['date'] = "";
                    $data['status'] = 0;
                    $data['condition'] = "";
                    foreach ($fields as $field) {
                        $data[$field['name']] = $row[$field['name']];
                    }

                    if (!empty($data)) {
                        DB::table('exam' . $exam_id)->insert($data);
                    }

                    // Check for new Poshtiban
                    $poshtiban = Poshtiban::where('codemeli', $row['poshtiban_code'])->first();
                    if ($poshtiban == null && strlen($row['poshtiban_code']) > 5 && $row['poshtiban'] != 'نام پشتیبان') {
                        Poshtiban::create([
                            'name' => $row['poshtiban'],
                            'mobile' => '',
                            'codemeli' => $row['poshtiban_code'],
                            'status' => 1
                        ]);
                    }
                    // End

                    // Check for new Zone
                    $zone = Zone::where('name',$row['zone'])->first();
                    if($zone == null && strlen($row['zone']) > 3 && $row['zone'] != 'منطقه'){
                        Zone::create([
                            'name' => $row['zone']
                        ]);
                    }
                    // End

                    // Relation between Hozeh and Modir
                    if (strlen($row['poshtiban_code']) > 6) {
                        ModirPoshtiban::create([
                            'modir_code' => $row['modir_code'],
                            'poshtiban_code' => $row['poshtiban_code'],
                            'exam_id' => $exam_id
                        ]);
                    }
                    // End

                    // Check for new Modir
                    $modirC = Modir::where('codemeli', $row['modir_code'])->first();
                    if ($modirC == null && strlen($row['modir_code']) > 5 && $row['modir'] != 'مدیر حوزه') {
                        Modir::create([
                            'name' => $row['modir'],
                            'mobile' => $row['modir_mobile'],
                            'codemeli' => $row['modir_code'],
                            'status' => 1
                        ]);
                    }
                    // End

                    // Check for new Bazres
                    $bazres = Bazres::where('codemeli', $row['bazres_code'])->first();
                    if ($bazres == null && strlen($row['bazres_code']) > 5 && $row['bazres_code'] != 'کد ملی بازرس') {
                        Bazres::create([
                            'name' => $row['bazres_name'],
                            'mobile' => '',
                            'codemeli' => $row['bazres_code'],
                            'status' => 1
                        ]);
                    }
                    // End

                }
            });
        }

        $total = DB::table($table_name)->where('type', 1)->count();
        $exam = Exam::find($exam_id);
        $exam->update([
            'total' => $total
        ]);


        if ($request->hasFile('import_arrange')) {
            Excel::load($request->file('import_arrange')->getRealPath(), function ($reader) use ($exam_id) {
                $headerRowA = (($reader->all())->first()->keys())->toArray();
                foreach ($headerRowA as $key => $valueA) {
                    $fieldA[] = ['name' => $valueA];
                }
                foreach ($reader->toArray() as $key => $rowA) {

                    $dataA['exam_id'] = $exam_id;

                    foreach ($fieldA as $field) {
                        $dataA[$field['name']] = $rowA[$field['name']];
                    }

                    if (!empty($dataA)) {
                        Arrangement::insert($dataA);
                    }

                    // Check for new Hozeh
                    $hozeh = Hozeh::where('code', $rowA['hozeh_code'])->first();
                    if ($hozeh == null && strlen($rowA['hozeh_code']) > 3) {
                        Hozeh::create([
                            'code' => $rowA['hozeh_code'],
                            'zone' => $rowA['zone'],
                            'name' => $rowA['hozeh'],
                            'address' => $rowA['address']
                        ]);
                    }
                    // End

                    // Relation between Hozeh and Modir
                    if (strlen($rowA['modir_code']) > 5) {
                        HozehModir::create([
                            'modir_code' => $rowA['modir_code'],
                            'hozeh_code' => $rowA['hozeh_code'],
                            'bazres_code' => $rowA['bazres_code'],
                            'exam_id' => $exam_id
                        ]);
                    }
                    // End
                }
            });
        }
        response()->json(['messages' => ['با موفقیت پروژه آپلود گردید']])->send();
        die();
    }


    public function excelDownloadFull($exam_id)
    {
        // for remove codemeli and...
        $table_col = \Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('exam' . $exam_id);
        $remove = ["id", "bazres", "status", "type", "poshtiban_mobile", "modir_mobile", "poshtiban_code", "modir_code", "bazres_code"];
        $table_col = \array_diff($table_col, $remove);
        //end

        $header = DB::table("exam" . $exam_id)->where('type', 2)->select($table_col)->get()->toArray();
        $header[0]->date = 'تاریخ';
        $header[0]->condition = 'وضعیت';
        $data1 = DB::table("exam" . $exam_id)->where('type', 1)->select($table_col)->get()->toArray();
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

    }

}
