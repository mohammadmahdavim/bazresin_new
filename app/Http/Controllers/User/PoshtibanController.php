<?php

namespace App\Http\Controllers\User;

use App\lib\EnConverter;
use App\Mark;
use App\Modir;
use App\Poshtiban;
use App\PoshtibanHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PoshtibanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $navbar = ['name' => 'پشتیبان ها', 'description' => 'عملکرد پشتیبان ها'];
        $poshtibans = Poshtiban::paginate(20);
        $data = $request->all();
        if ($request->ajax()) {
            if (isset($data['query'])) {
                $search = EnConverter::fa2ar($data['query']);
                $poshtibans = Poshtiban::search($search, null, true, true)->paginate(20);
                return view('user.include.leader.poshtiban.index', [
                    'poshtibans' => $poshtibans,
                ]);
            }
            return view('user.include.leader.poshtiban.index', [
                'poshtibans' => $poshtibans,
            ]);
        }
        if (isset($data['query'])) {
            $search = str_replace('ی', 'ي', $data['query']);
            $poshtibans = Poshtiban::search($search, null, true, true)->paginate(20);
        }
        return view('user.leader.poshtiban.index', [
            'poshtibans' => $poshtibans,
            'navbar' => $navbar,
            'data' => $data
        ]);
    }

    public function searchAjax(Request $request)
    {
        $poshtibans = Poshtiban::paginate(20);
        $data = $request->all();
        if ($request->ajax()) {
            if (isset($data['query'])) {
                $search = EnConverter::fa2ar($data['query']);
                $poshtibans = Poshtiban::search($search, null, true, true)->paginate(20);
                return view('user.include.leader.poshtiban.index', [
                    'poshtibans' => $poshtibans,
                ]);
            }
            return view('user.include.leader.poshtiban.index', [
                'poshtibans' => $poshtibans,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($codemeli)
    {
        $poshtiban = Poshtiban::where('codemeli', $codemeli)->first();
        $histories = PoshtibanHistory::where('poshtiban_code', $codemeli)->first();
        $modir_code = Mark::where('poshtiban_code', $codemeli)->first()['modir_code'];
        $marks = Mark::mean_mark_poshtiban($codemeli);
        $means = Mark::mean_mark_hozeh($modir_code);
        $variances = Mark::variance_hozeh($modir_code);
        $mean_poshtiban = [];
        foreach ($marks as $key => $mark) {
            if (max($marks) - min($marks) > 0) {
                $mean_poshtiban[$key] = ($mark - min($marks)) / (max($marks) - min($marks));
            }
        }

        $mean_hozeh = [];
        foreach ($means as $key => $mean) {
            if (max($marks) - min($marks) > 0) {
                $mean_hozeh[$key] = ($mean - min($means)) / (max($means) - min($means));
            }
        }

        $exams = Mark::where('poshtiban_code', $codemeli)->groupBy('exam_id')->get();

        $mark_poshtiban = [];
        foreach ($exams as $key => $exam) {
            $mark_poshtiban[$exam->exam_id] = $exam->total;
        }
        $mark_mean_hozeh = [];
        foreach ($exams as $key => $exam) {
            $mark_mean_hozeh[$exam->exam_id] = Mark::where('exam_id', $exam->exam_id)->avg('total');
        }

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
            'extera_mark' => 'نمره اضافی',
        ];


        $navbar = ['name' => 'ریز گزارش عملکرد', 'description' => $poshtiban->name];
        $inspections = PoshtibanHistory::where('poshtiban_code',$codemeli)->orderBy('id','desc')->get();
        $arzyabi = [0 => 'ارزیابی پاییز', 1 => 'ارزیابی تابستان', 2 => 'ارزیابی بهار'];
        return view('user.leader.poshtiban.show', [
            'histories' => $histories,
            'navbar' => $navbar,
            'poshtiban' => $poshtiban,
            'translates' => $translates,
            'mean_poshtiban' => $mean_poshtiban,
            'mean_hozeh' => $mean_hozeh,
            'variances' => $variances,
            'mark_poshtiban' => $mark_poshtiban,
            'mark_mean_hozeh' => $mark_mean_hozeh,
            'exams' => $exams,
            'inspections' => $inspections,
            'arzyabi' => $arzyabi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
