<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\lib\BackUP;
use App\Exam;
use App\User;
use Auth;
use DB;
use Excel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Input;
use jDate;
use Session;

class ExamUpdateController extends Controller
{
    public function index($exam_id)
    {
        $header = DB::table('exam' . $exam_id)->where('type', 2)->first();
        $items = DB::table('exam' . $exam_id)->where('type', 3)->where('id', '!=', 1)->get();
        $exam = Exam::find($exam_id);
        $idone = DB::table('exam' . $exam_id)->where('id', 1)->first();
        $navbar = ['name' => 'ویرایش آزمون', 'description' => $exam->name . 'اصلاح نمایش'];
        return view('admin.exam.update', ['navbar' => $navbar,
            'header' => $header,
            'totalproj' => $exam,
            'exam' => $exam_id,
            'items' => $items,
            'idone' => $idone
        ]);
    }

    public function deletecol($exam_id, $column_name)
    {
        Schema::table('exam' . $exam_id, function ($table) use ($column_name) {
            $table->dropColumn($column_name);
        });
        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
        return redirect('/admin/exams/update/' . $exam_id);
    }

    public function edititem(Request $request)
    {
        $id = $request->exam_id;
        $col = $request->colname;
        $newname = $request->newname;
        $project = 'exam' . $id;
        $itemid = $request->itemid;

        DB::table($project)->where('id', $itemid)->update([$col => $newname]);

        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!')->autoClose(3000);
        return redirect('/admin/exams/update/' . $id);
    }

    public function updatename(Request $request)
    {
        $id = $request->exam_id;
        $exam = Exam::find($id);
        $exam->update($request->all());
        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!')->autoClose(3000);
        return redirect('/admin/exams');
    }


    public function delitem($id, $itemid, $column)
    {
        $project = 'exam' . $id;
        DB::table($project)->where('id', $itemid)->update([$column => ""]);
        alert()->success('بروزرسانی موفق', 'آیتم با موفقیت حذف شد!')->autoClose(3000);
        return redirect('/admin/exams/update/' . $id);
    }


    public function editname(Request $request)
    {
        $id = $request->exam_id;
        $col = $request->colname;
        $newname = $request->newname;
        $project = 'exam' . $id;
        DB::table($project)->where('type', 2)->update([$col => $newname]);

        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
        return redirect('/admin/exams/update/' . $id);

    }

    public function additem(Request $request)
    {
        $id = $request->exam_id;
        $col = $request->colname;
        $name = $request->name;
        $project = 'exam' . $id;

        $typecount = DB::table($project)->where('type', 3)->count();
        $typecolcount = DB::table($project)->where('type', 3)->where($col, '!=', "")->count();

        if ($typecount == $typecolcount) {
            DB::table($project)->insert(
                ['status' => 10, 'type' => 3, $col => $name, 'author' => "", 'date' => "", 'condition' => "", 'bazres' => ""]
            );
        } else {
            $xx = DB::table($project)->where('type', 3)->whereNull($col)->orwhere($col, "")->orderBy('id', 'asc')->first();

            DB::table($project)->where('id', $xx->id)->update([$col => $name]);
        }

        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
        return redirect('/admin/exams/update/' . $id);

    }


    public function addcol(Request $request)
    {
        $id = $request->exam_id;
        $col = $request->colname;
        $name = $request->name;
        $exam = 'exam' . $id;
        $items = $request->items;
        $item = explode('/', $items);
        $GLOBALS['newcolumn'] = $request->newcol;
        $GLOBALS['oldcolumn'] = $col;

        // Check state in project
        $isColExist = Schema::connection('mysql')->hasColumn($exam, $request->newcol);
        if ($isColExist) {
            alert()->warning('خطا !', 'این نام ستون در دیتابیس برای این پروژه از قبل موجود است');
            return redirect('/admin/exams/update/' . $id);
        }
        // End

        Schema::table($exam, function ($table) {
            $table->string($GLOBALS['newcolumn'], 200)->after($GLOBALS['oldcolumn'])->nullable();
        });
        DB::table($exam)->where('type', 2)->update([$request->newcol => $name]);
        $data['proj_id'] = $id;
        $data['name_culomn'] = $request->newcol;

        $typecount = DB::table($exam)->where('type', 3)->count();
        $itemcount = count($item);
        $idtype = DB::table($exam)->where('type', 3)->orderBy('id', 'asc')->select('id')->get()->toArray();

        $data = array();
        foreach ($idtype as $idtype) {
            $data[] = (array)$idtype;
        }


        $x = 2;

        if ($request->select == "on") {
            DB::table($exam)->where('id', 1)->update([$request->newcol => 2]);

            while ($x <= $typecount && $x - 2 < $itemcount) {

                $fd = implode(" ", $data[$x - 1]);

                DB::table($exam)->where('id', $fd)->update([$request->newcol => $item[$x - 2]]);

                $x = $x + 1;
            }
            if ($itemcount >= $typecount) {

                while ($x - 2 < $itemcount) {

                    DB::table($exam)->insert(
                        ['status' => 10, 'type' => 3, $request->newcol => $item[$x - 2], 'author' => "", 'date' => "", 'condition' => "", 'bazres' => ""]
                    );
                    $x = $x + 1;
                }
            }
            alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
            return redirect('/admin/exams/update/' . $id);
        } else {
            DB::table($exam)->where('id', 1)->update([$request->newcol => 1]);
            alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
            return redirect('/admin/exams/update/' . $id);
        }

    }

    public function edit($id)
    {
        $project = Exam::find($id);
        return view('admin.project.edit', ['project' => $project]);
    }


    public function downloadExel($id)
    {
        $select1 = ['author', 'date', 'status', 'condition'];
        $select2 = CulomnsModel::where('proj_id', $id)->pluck('name_culomn')->toArray();
        $selects = array_merge($select1, $select2);
        $values = DB::table("proj" . $id)->select($selects)->get()->toArray();
        $data = array();
        foreach ($values as $value) {
            $data[] = (array)$value;
        }
        return Excel::create('ProjectExcel', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {

                $sheet->fromArray($data);

            });
        })->download('xlsx');
    }


    /**
     * Create dynamic table along with dynamic fields
     *
     * @param       $table_name
     * @param array $fields
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request)
    {

        $project = Exam::find($request->id);
        if ($project->update($request->all())) {
            return $this->operate($request, $request->id);
        }

    }

    public function operate(Request $request, $id)
    {
        //Delete old Table
        $project = Exam::find($id);
        if ($project->update(['update' => 1])) {
            $backup = BackUP::BackUP();
            $name = 'exam' . $id . '.sql';
            Schema::drop('exam' . $id);
        }
        //End Delete

        $table_name = 'exam' . $id;
        $path = $request->file('import_file')->getRealPath();
        $headerRow = (((Excel::load($path))->all())->first()->keys())->toArray();

        foreach ($headerRow as $key => $value) {
            $fields[] = ['name' => $value, 'type' => 'mediumText'];
        }

        $headers = CulomnsModel::where('proj_id', $id)->get();
        foreach ($headers as $header) {
            $header->delete();
        }

        foreach ($headerRow as $key => $value) {
            if ($key >= 4) {
                $data['proj_id'] = $id;
                $data['name_culomn'] = $value;
                if (!empty($data)) {
                    CulomnsModel::insert($data);
                }
            }

        }

        return $this->createTable($table_name, $fields, $request);

    }


    public function createTable($table_name, $fields = [], $request)
    {
        // check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {
                $table->increments('id');
                $table->string('bazres')->nullable();
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        $table->{$field['type']}($field['name'])->nullable();
                    }
                }

            });

            return $this->importExcel($request, $table_name);
        }

        return response()->json(['message' => 'Given table is already existis.'], 400);
    }


    public function importExcel(Request $request, $table_name)
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        set_time_limit(300);

        if ($request->hasFile('import_file')) {
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                $proj_id = Exam::where('update', 1)->first()['id'];
                $headerRow = (($reader->all())->first()->keys())->toArray();
                foreach ($headerRow as $key => $value) {
                    $fields[] = ['name' => $value];
                }
                foreach ($reader->toArray() as $key => $row) {
                    foreach ($fields as $field) {
                        $data[$field['name']] = $row[$field['name']];
                    }
                    if (!empty($data)) {
                        DB::table('exam' . $proj_id)->insert($data);
                    }
                }
            });
        }


        $allCall = DB::table($table_name)->where('type', 1)->count();
        $idp = Exam::where('update', 1)->first()['id'];
        $ProjUpdateAllCall = Exam::find($idp);
        $ProjUpdateAllCall->update([
            'all_call' => $allCall,
            'update' => 0
        ]);

        alert()->success('بروزرسانی موفق', 'باموفقیت در سامانه بروزرسانی صورت گرفت!');
        return redirect('/admin/project');


    }


    public function ajax_change_type_column(Request $request)
    {
        $column = $request->column;
        $data = DB::table('exam' . $request->proj_id)->where('id', 1)->limit(1);

        if ($data->update([$column => $request->type])) {
            return response('ok', 200);
        }
        return response('error', 403);


    }


    public function ajax_change_format_column(Request $request)
    {
        $tbl = 'exam' . $request->proj_id;
        Schema::table($tbl, function (Blueprint $table) use ($request) {
            $column = $request->column;
            $type = $request->type;
            $table->$type($column)->change();
        });
        return response('ok', 200);

    }


    public function changeRequire(Request $request)
    {
        $check = DB::table('exam' . $request->proj_id)
            ->where('type', 4)->first();
        if ($check == null) {
            $row = DB::table('exam' . $request->proj_id)->insert([
                'type' => 4,
                'status' => 0,
                'bazres' => '',
                'date' => '',
                'condition' => ''
            ]);

            $req = DB::table('exam' . $request->proj_id)
                ->where('type', 4)->update([
                    $request->column => $request->type
                ]);
        } else {
            DB::table('exam' . $request->proj_id)
                ->where('type', 4)->update([
                    $request->column => $request->type
                ]);
        }


        return response()->json([
            'status' => 200
        ]);
    }
}
