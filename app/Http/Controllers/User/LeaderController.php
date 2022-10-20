<?php

namespace App\Http\Controllers\User;

use App\DetailsIar;
use App\Exam;
use App\FormIAR;
use App\PoshtibanHistory;
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Excel;
class LeaderController extends Controller
{
    public function dataEntry()
    {
        $exams = Exam::orderBy('id','desc')->paginate('6');
        $navbar = ['name' => 'آزمون ها', 'description' => 'مدیریت آزمون ها'];
        return view('user.leader.dataentry',[
            'navbar' => $navbar,
            'exams' => $exams
        ]);
    }


    public function indexDataEntry($id)
    {
        $azmoon = Exam::find($id);
        $zones_id = auth()->user()->zones->pluck('id')->toArray();
        $zones = Zone::whereIn('id',$zones_id)->pluck('name')->toArray();
        $navbar = ['name' => 'آزمون ها', 'description' => 'مدیریت آزمون '.$azmoon->name];
        $records = DB::table('exam' . $id)->whereIn('zone',$zones)->get();
        $modir_codes = DB::table('exam' . $id)
            ->whereIn('zone',$zones)
            ->pluck('modir_poshtiban', 'modir_poshtiban_code')
            ->toArray();
        return view('user.leader.show', ['records' => $records, 'navbar' => $navbar, 'azmoon' => $azmoon, 'modir_codes' => $modir_codes]);
    }

    public function poshtiban($exam_id, $id)
    {
        $navbar = ['name' => 'آزمون ها', 'description' => 'آزمون های فعال'];
        $azmoon = Exam::find($exam_id);
        $data = DB::table('exam' . $exam_id)->find($id);
        $histories = PoshtibanHistory::where('poshtiban_code', $data->poshtiban_code)
            ->orderby('id', 'desc')
            ->get();
        $header = DB::table('exam' . $exam_id)->where('type', 2)->first();

        $count = DB::table('exam' . $exam_id)->where('type', '3')->count();
        $limit = $count - 1;
        $select = DB::table('exam' . $exam_id)->where('type', '3')->take($limit)->get();
        $type_select = DB::table('exam' . $exam_id)->orderby('id', 'asc')->take(1)->get();
        return view('user.leader.edit', ['histories' => $histories, 'data' => $data, 'azmoon' => $azmoon, 'type_select' => $type_select, 'select' => $select, 'header' => $header, 'navbar' => $navbar]);
    }


    public function excelDownloadFull($exam_id)
    {
        // for remove codemeli and...
        $table_col = \Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('exam' . $exam_id);
        $remove = ["id", "bazres", "status", "type", "poshtiban_mobile", "modir_mobile", "poshtiban_code", "modir_code", "bazres_code"];
        $table_col = \array_diff($table_col, $remove);
        //end

        $zones_id = auth()->user()->zones->pluck('id')->toArray();
        $zones = Zone::whereIn('id',$zones_id)->pluck('name')->toArray();

        $header = DB::table("exam" . $exam_id)->where('type', 2)->select($table_col)->get()->toArray();
        $header[0]->date = 'تاریخ';
        $header[0]->condition = 'وضعیت';
        $data1 = DB::table("exam" . $exam_id)->whereIn('zone',$zones)->where('type', 1)->select($table_col)->get()->toArray();
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

    public function createPdf($exam_id)
    {
        $zones_id = auth()->user()->zones->pluck('id')->toArray();
        $zones = Zone::whereIn('id',$zones_id)->pluck('name')->toArray();
        $modir_code = DB::table('exam'.$exam_id)->whereIn('zone',$zones)->groupBy('modir_code')->pluck('modir_code')->toArray();
        $datas = FormIAR::whereIn('modir_code', $modir_code)->where('exam_id', $exam_id)->get();
        return view('user.leader.pdf', [
            'datas' => $datas,
            'exam_id' => $exam_id,
        ]);
    }
}
