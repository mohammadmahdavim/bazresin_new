<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = 'marks';
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public static function mark($codemeli, $exam_id)
    {
        $mark = Mark::where('poshtiban_code', $codemeli)
            ->where('exam_id', $exam_id)
            ->first();
        return $mark == null ? '0' : $mark->total;
    }

    public static function mean_mark_hozeh($modir_code)
    {
        $marks = Mark::where('modir_code', $modir_code);
        $mean = [
            'card' => $marks->avg('card'),
            'hozor_ontime' => $marks->avg('hozor_ontime'),
            'form_bazresi' => $marks->avg('form_bazresi'),
            'takhteh_nevisi' => $marks->avg('takhteh_nevisi'),
            'num_barnameh' => $marks->avg('num_barnameh'),
            'num_khodamoz' => $marks->avg('num_khodamoz'),
            'num_book_tabestan' => $marks->avg('num_book_tabestan'),
            'rafe_eshkal' => $marks->avg('rafe_eshkal'),
            'num_khodnegari' => $marks->avg('num_khodnegari'),
            'quality_face' => $marks->avg('quality_face'),
            'extera_mark' => $marks->avg('extera_mark'),
        ];

        return $mean;

    }

    public static function mean_mark_poshtiban($poshtiban_code)
    {
        $marks = Mark::where('poshtiban_code', $poshtiban_code);
        $mean = [
            'card' => $marks->avg('card'),
            'hozor_ontime' => $marks->avg('hozor_ontime'),
            'form_bazresi' => $marks->avg('form_bazresi'),
            'takhteh_nevisi' => $marks->avg('takhteh_nevisi'),
            'num_barnameh' => $marks->avg('num_barnameh'),
            'num_khodamoz' => $marks->avg('num_khodamoz'),
            'num_book_tabestan' => $marks->avg('num_book_tabestan'),
            'rafe_eshkal' => $marks->avg('rafe_eshkal'),
            'num_khodnegari' => $marks->avg('num_khodnegari'),
            'quality_face' => $marks->avg('quality_face'),
            'extera_mark' => $marks->avg('extera_mark'),
        ];

        return $mean;
    }

    public static function variance_hozeh($modir_code)
    {
        $marks = Mark::where('modir_code', $modir_code);
        $mean = [
            'card' => $marks->pluck('card')->toArray(),
            'hozor_ontime' => $marks->pluck('hozor_ontime')->toArray(),
            'form_bazresi' => $marks->pluck('form_bazresi')->toArray(),
            'takhteh_nevisi' => $marks->pluck('takhteh_nevisi')->toArray(),
            'num_barnameh' => $marks->pluck('num_barnameh')->toArray(),
            'num_khodamoz' => $marks->pluck('num_khodamoz')->toArray(),
            'num_book_tabestan' => $marks->pluck('num_book_tabestan')->toArray(),
            'rafe_eshkal' => $marks->pluck('rafe_eshkal')->toArray(),
            'num_khodnegari' => $marks->pluck('num_khodnegari')->toArray(),
            'quality_face' => $marks->pluck('quality_face')->toArray(),
            'extera_mark' => $marks->pluck('extera_mark')->toArray(),
        ];
        return $mean;
    }

    public static function Stand_Deviation($arr)
    {
        $num_of_elements = count($arr);

        $variance = 0.0;

        // calculating mean using array_sum() method
        $average = array_sum($arr) / $num_of_elements;

        foreach ($arr as $i) {
            // sum of squares of differences between
            // all numbers and means.
            $variance += pow(($i - $average), 2);
        }
        return (float)sqrt($variance / $num_of_elements);
    }


    public static function mean_mark_state()
    {

    }
}
