<?php

namespace App\Http\Controllers\Admin;

use App\Gozineh;
use App\QuestionIar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IarController extends Controller
{
    public function index()
    {
        $navbar = ['name' => 'فرم IAR', 'description' => 'فرم ارزش یابی کیفیت برگزاری آزمون'];
        return view('admin.iar.index', ['navbar' => $navbar]);
    }


    public function q_index()
    {
        $navbar = ['name' => 'فرم IAR', 'description' => 'مدیریت سوال های فرم IAR'];
        $questions = QuestionIar::all();
        return view('admin.iar.question.index', ['navbar' => $navbar, 'questions' => $questions]);
    }


    public function q_create()
    {
        $navbar = ['name' => 'فرم IAR', 'description' => 'ایجاد سوال برای IAR'];
        return view('admin.iar.question.create', ['navbar' => $navbar]);
    }

    public function q_store(Request $request)
    {

        Validator::make($request->all(), [
            'question' => 'required',
            'mark' => 'required|is_not_persian',
            'type' => 'required'
        ])->validate();

        $sum = QuestionIar::where('status', 1)->sum('mark');
        $total = $sum + $request->mark;
        if ($total > 100) {
            return back()->withErrors("مجموع نمرات سوالات فعال برابر $total شده است و این مقدار نباید بیشتر از 100 گردد");
        }

        $id = QuestionIar::create([
            'question' => $request->question,
            'description' => $request->description,
            'mark' => $request->mark,
            'type' => $request->type
        ])->id;

        foreach ($request->gozineh as $gozineh) {
            if ($gozineh != null) {
                Gozineh::create([
                    'question_id' => $id,
                    'name' => $gozineh
                ]);
            }
        }

        alert()->success('ذخیره شد');
        return redirect('/admin/iar/question');

    }


    public function q_edit($id)
    {
        $question = QuestionIar::find($id);
        $gozineh = QuestionIar::find($id)->gozineh;
        return view('admin.iar.question.edit', ['question' => $question, 'gozineh' => $gozineh]);
    }

    public function q_update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'required',
            'mark' => 'required|is_not_persian',
            'type' => 'required'
        ]);

        $sum = QuestionIar::where('status', 1)->sum('mark');
        $total = $sum + $request->mark;
        if ($total > 105) {
            return 'max_denied';
        }

        $question = QuestionIar::find($id);
        $question->update([
            'question' => $request->question,
            'description' => $request->description,
            'mark' => $request->mark,
            'type' => $request->type,
            'status' => $request->status
        ]);

        if($request->gozineh){
            QuestionIar::find($id)->gozineh()->delete();
            foreach ($request->gozineh as $gozineh) {
                if ($gozineh != null) {
                    Gozineh::create([
                        'question_id' => $id,
                        'name' => $gozineh
                    ]);
                }
            }
        }

        return 'ok';
    }

    public function q_destroy($id)
    {
        $data = QuestionIar::find($id);
        if ($data != null) {
            $data->delete($id);
            return 'ok';
        }
        return 'fail';
    }
}
