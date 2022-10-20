<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = ['name', 'user_id', 'date', 'supervisor', 'description', 'date', 'total', 'status'];

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function iar()
    {
        return $this->hasMany(FormIAR::class);
    }

    public function poshtiban_history()
    {
        return $this->hasMany(PoshtibanHistory::class);
    }

    public static function numberModir($exam_id, $modir_code)
    {
        $modirs = 0;
        $modirs = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->groupBy('modir_poshtiban_code')
            ->get();
        return $modirs->count();
    }

    public static function numberPoshtiban($exam_id, $modir_code)
    {
        $poshtiban = 0;
        $poshtiban = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->get();
        return $poshtiban->count();
    }

    public static function totalStudent($exam_id, $modir_code)
    {
        $total = 0;
        $total = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->sum('total_student');

        return ($total != null ? $total : '0');
    }

    public static function totalKonkur($exam_id, $modir_code)
    {
        $total = 0;
        $total = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->sum('konkur');
        return ($total != null ? $total : '0');
    }

    public static function totalPayeh($exam_id, $modir_code)
    {
        $total = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->sum('payeh');
        return ($total != null ? $total : '0');
    }

    public static function totalDabestan($exam_id, $modir_code)
    {
        $total = 0;
        $total = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->sum('dabestan');
        return ($total != null ? $total : '0');
    }

    public static function totalHonarestan($exam_id, $modir_code)
    {
        $total = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->sum('honarestan');
        return ($total != null ? $total : '0');
    }

    public static function sarGroup($exam_id, $modir_code)
    {
        $leader = Arrangement::where('exam_id', $exam_id)
            ->where('modir_code', $modir_code)
            ->first();
        if ($leader == null) {
            return 'ندارد';
        } else {
            return $leader->leader;
        }
    }

    public static function Hozor($exam_id, $modir_code)
    {
        $hozor = 0;
        $student = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code);

        foreach ( $student->select('hozor_ontime','hozor_delay')->get() as $st ){
            $hozor += ($st->hozor_ontime != null ? $st->hozor_ontime : 0) + ($st->hozor_delay != null ? $st->hozor_delay : 0);
        }

        $total = $student->sum('total_student');
        $percent = ($hozor * 100) / $total;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }

    public static function Barnameh($exam_id, $modir_code)
    {
        $barnameh = 0;
        $student = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code);

        foreach ( $student->select('num_barnameh')->get() as $st ){
            $barnameh += ($st->num_barnameh != null ? $st->num_barnameh : 0);
        }

        $total = 1;
        foreach ($student->select('hozor_ontime','hozor_delay')->get() as $tot){
            $total += ($tot->hozor_ontime != null ? $tot->hozor_ontime : 0) + ($tot->hozor_delay != null ? $tot->hozor_delay : 0);
        }
        $percent = ($barnameh * 100) / $total;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }


    public static function Khodamoz($exam_id, $modir_code)
    {
        $khodamoz = 0 ;
        $student = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code);

        foreach ( $student->select('num_khodamoz')->get() as $st ){
            $khodamoz += ($st->num_khodamoz != null ? $st->num_khodamoz : 0);
        }

        $total = 1;
        foreach ($student->select('hozor_ontime','hozor_delay')->get() as $tot){
            $total += ($tot->hozor_ontime != null ? $tot->hozor_ontime : 0) + ($tot->hozor_delay != null ? $tot->hozor_delay : 0);
        }

        $percent = ($khodamoz * 100) / $total;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }


    public static function Book($exam_id, $modir_code)
    {
        $book = 0 ;
        $student = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code);

        foreach ( $student->select('num_book_tabestan')->get() as $st ){
            $book += ($st->num_book_tabestan != null ? $st->num_book_tabestan : 0);
        }

        $total = 1;
        foreach ($student->select('hozor_ontime','hozor_delay')->get() as $tot){
            $total += ($tot->hozor_ontime != null ? $tot->hozor_ontime : 0) + ($tot->hozor_delay != null ? $tot->hozor_delay : 0);
        }
        $percent = ($book * 100) / $total;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }

    public static function Takhteh($exam_id, $modir_code, $poshtiban)
    {
        $dones = 0;
        $dones = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->where('type',1)->where('takhteh_nevisi', 'دارد')->get()->count();

        $percent = ($dones * 100) / $poshtiban;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }


    public static function Khodnegari($exam_id, $modir_code)
    {
        $khodnegari = 0;
        $student = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code);

        foreach ( $student->select('num_khodnegari')->get() as $st ){
            $khodnegari += ($st->num_khodnegari != null ? $st->num_khodnegari : 0);
        }

        $total = 1;
        foreach ($student->select('hozor_ontime','hozor_delay')->get() as $tot){
            $total += ($tot->hozor_ontime != null ? $tot->hozor_ontime : 0) + ($tot->hozor_delay != null ? $tot->hozor_delay : 0);
        }
        $percent = ($khodnegari * 100) / $total;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }

    public static function RafeEshkal($exam_id, $modir_code, $poshtiban)
    {
        $dones = 0;
        $dones = DB::table('exam' . $exam_id)
            ->where('modir_code', $modir_code)
            ->where('type',1)->where('rafe_eshkal', 'دارد')->get()->count();

        $percent = ($dones * 100) / $poshtiban;
        if (round($percent) == 0) {
            return '0';
        }
        return round($percent);
    }

    public static function Mark($exam_id, $modir_code)
    {
        $mark = 0;
        $mark = FormIAR::where('exam_id', $exam_id)
            ->where('modir_code', $modir_code)->first();
        if ($mark == null) {
            return '';
        } else {
            return $mark->mark;
        }
    }

}
