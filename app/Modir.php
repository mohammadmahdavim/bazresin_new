<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Nicolaslopezj\Searchable\SearchableTrait;

class Modir extends Model
{
    use SearchableTrait;
    protected $table = 'modir';
    protected $fillable = ['name', 'mobile', 'personnel_code', 'codemeli', 'status'];
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'mobile' => 10,
        ],
    ];
    public function iar()
    {
        return $this->hasMany('App\FormIar', 'modir_id');
    }

    public static function getName($codemeli)
    {
        $modir = self::where('codemeli', $codemeli)->first();
        if ($modir == null) {
            return 'در سامانه ثبت نشده';
        }
        return $modir->name;
    }

    public static function getTotalMark($modir_code, $exams)
    {
        $mark = 0;
        $count = 0;
        foreach ($exams as $key => $exam) {
            if (FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first() != null) {
                $mark += FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first()->mark;
                $count += 1;
            }

        }
        return round($mark / ($count == 0 ? 1 : $count), 1, PHP_ROUND_HALF_UP);
    }


    public static function getMarkNazm($modir_code, $exams)
    {
        $mark = 0;
        $count = 0;
        foreach ($exams as $key => $exam) {
            if (FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first() != null) {
                $mark += FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first()->mark_nazm;
                $count += 1;
            }

        }
        return round($mark / ($count == 0 ? 1 : $count), 1, PHP_ROUND_HALF_UP);
    }


    public static function getMarkPerformance($modir_code, $exams)
    {
        $mark = 0;
        $count = 0;
        foreach ($exams as $key => $exam) {
            if (FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first() != null) {
                $mark += FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first()->mark_performance;
                $count += 1;
            }

        }

        return round($mark / ($count == 0 ? 1 : $count), 1, PHP_ROUND_HALF_UP);
    }


    public static function getExam($exam_id)
    {
        return Exam::find($exam_id)->name;
    }

    public static function getItemIarTotal($modir_code, $exams, $question_id)
    {

        $mark = 0;
        $count = 0;
        foreach ($exams as $exam) {
            if (FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first() != null) {
                $iar_id = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first()->id;
                if (DetailsIar::where('iar_id', $iar_id)->where('question_id', $question_id)->first() != null) {
                    $mark += DetailsIar::where('iar_id', $iar_id)->where('question_id', $question_id)->first()->mark;
                    $count += 1;
                }

            }
        }
        return round($mark / ($count == 0 ? 1 : $count), 1, PHP_ROUND_HALF_DOWN);
    }

    public static function getItemIarExam($modir_code, $exams, $question_id)
    {
        $mark = 0;
        $count = 0;
        $examss = array();
        foreach ($exams as $exam) {
            if (FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first() != null) {
                $iar_id = FormIAR::where('modir_code', $modir_code)->where('exam_id', $exam)->first()->id;
                if (DetailsIar::where('iar_id', $iar_id)->where('question_id', $question_id)->first() != null) {
                    $examss[] = $exam;
                }

            }
        }
        $data = array();
        foreach ($examss as $exam) {
            $data[] = str_replace('بازرسی','',Exam::find($exam)->name);
        }
        return implode(' - ',$data);
    }


    public static function getQuestion($question_id)
    {
            $question = \App\QuestionIar::find($question_id);
            return $question->question;
    }

    public static function getGozineh($description){
        $parts = explode(' - ',$description);
        foreach ($parts as $part){
            if(is_numeric($part)){
                $gozineh = \App\Gozineh::whereIn('id',$parts)->pluck('name')->toArray();
                return implode(' - ', $gozineh);
            } else {
                return $part;
            }
        }
    }
}
