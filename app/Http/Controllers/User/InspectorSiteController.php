<?php

namespace App\Http\Controllers\User;

use App\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InspectorSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::latest()->get();
        $navbar = ['name' => 'آزمون ها', 'description' => 'آمار حضور دانش آموزان'];
        return view('user.inspector.index',['exams' => $exams, 'navbar' => $navbar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modirs = DB::table('exam'.$id)
            ->where('type',1)
            ->select('zone','modir','modir_code','modir_mobile', DB::raw('SUM(`hozor_ontime`) as hozor_ontime'),DB::raw('SUM(`hozor_delay`) as hozor_delay'),DB::raw('SUM(`total_student`) as total'))
            ->groupBy('modir_code')
            ->orderBy('hozor_ontime','desc')
            ->get();
        $exam = Exam::findOrFail($id);
        $navbar = ['name' => $exam->name, 'description' => $exam->date];
        return view('user.inspector.show',['modirs' => $modirs, 'navbar' => $navbar]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
