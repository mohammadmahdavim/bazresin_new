<?php

namespace App\Http\Controllers\User;

use App\FormIAR;
use App\lib\EnConverter;
use App\Mark;
use App\Modir;
use App\Poshtiban;
use App\PoshtibanHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $navbar = ['name' => 'مدیران', 'description' => 'عملکرد مدیران'];
        $modirs = Modir::paginate(20);
        $data = $request->all();
        if ($request->ajax()) {
            if (isset($data['query'])) {
                $search = EnConverter::fa2ar($data['query']);
                $modirs = Modir::search($search, null, true, true)->paginate(20);
                return view('user.include.leader.modir.index', [
                    'modirs' => $modirs,
                ]);
            }
            return view('user.include.leader.modir.index', [
                'modirs' => $modirs,
            ]);
        }
        if (isset($data['query'])) {
            $search = str_replace('ی', 'ي', $data['query']);
            $modirs = Modir::search($search, null, true, true)->paginate(20);
        }
        return view('user.leader.modir.index', [
            'modirs' => $modirs,
            'navbar' => $navbar,
            'data' => $data
        ]);
    }

    public function searchAjax(Request $request)
    {
        $modirs = Modir::paginate(20);
        $data = $request->all();
        if ($request->ajax()) {
            if (isset($data['query'])) {
                $search = EnConverter::fa2ar($data['query']);
                $modirs = Modir::search($search, null, true, true)->paginate(20);
                return view('user.include.leader.modir.index', [
                    'modirs' => $modirs,
                ]);
            }
            return view('user.include.leader.modir.index', [
                'modirs' => $modirs,
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
        $modir = Modir::where('codemeli', $codemeli)->first();
        $iars = FormIAR::where('modir_code',$codemeli)->orderBy('id','desc')->get();

        $navbar = ['name' => 'ریز گزارش عملکرد', 'description' => $modir->name];
        return view('user.leader.modir.show', [
            'navbar' => $navbar,
            'modir' => $modir,
            'iars' => $iars
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
