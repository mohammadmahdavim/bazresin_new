<?php

function add_span($s)
{
    $a = preg_replace('/\s+/', '-', $s);
    $b = explode('-', $a);
    foreach ($b as $key => $value) {
        if (!preg_match('/[^A-Za-z0-9-]+/', $value)) {
            $new_value = '<span style="font-family:DejaVuSansCondensed">' . $value . '</span>';
            $s = str_replace($value, $new_value, $s);
        }
    }

    return $s;
}

function getQuestion($question_id)
{
    $question = \App\QuestionIar::find($question_id);
    return $question->question;
}

function getGozineh($description)
{
    $parts = explode(' - ', $description);
    foreach ($parts as $part) {
        if (is_numeric($part)) {
            $gozineh = \App\Gozineh::whereIn('id', $parts)->pluck('name')->toArray();
            return implode(' - ', $gozineh);
        } else {
            return $part;
        }
    }
}

function getHozeh($hozeh_code)
{
    $hozeh = \App\Hozeh::where('code', $hozeh_code)->first();
    return $hozeh;
}

function getModir($modir_code)
{
    $modir = \App\Modir::where('codemeli', $modir_code)->first();
    return $modir;
}

function getBazres($bazres_code)
{
    $bazres = \App\Bazres::where('codemeli', $bazres_code)->first();
    return $bazres;
}

$html = '<style>
    body {
      direction: rtl;
      font-family:byekan,arial;
      font-size : 11px;
    }
.page-break {
    page-break-after: always;
}
  </style>';


foreach ($modirs as $data) {
    $html .= '<div class="header">

        <div class="col-md-6">
            <p>
                <span> نام مدیر حوزه :  </span>
                <span>' . \App\Modir::getName($data) . ' </span >
            </p >
            <p >
                <span > میانگین امتیاز کل مدیر حوزه :  </span >
                <span >' . \App\Modir::getTotalMark($data, $exams) . ' از 100</span>
            </p>
        </div >

        <div class="col-md-6" style = "text-align:left" >
            <p >
                <span> رنگ کل نظم در حوزه : </span>
                <span>' . \App\Modir::getMarkNazm($data, $exams) . ' از 5</span>
            </p>
            <p>
                <span>  رنگ کل کارهای کیفی در حوزه : </span>
                <span>' . \App\Modir::getMarkPerformance($data, $exams) . ' از 5</span >
            </p >
        </div>
        <div style = "clear:both" ></div>
    </div>';

    $html .= '<div style="width:100%;float:right;margin-top:20px">

         <table class="table table-bordered">
            <tr>
                <td style="font-size:13px">ردیف</td>
                <td style="font-size:13px">آزمون</td>
                <td style="font-size:13px;text-align:center">نمره (از 100)</td>
                <td style="font-size:13px;text-align:center">نمره نظم (از 5)</td>
                <td style="font-size:13px;text-align:center">نمره کارهای کیفی (از 5)</td>
                <td style="font-size:13px;text-align:center">درصد حضور دانش آموز (از 100%)</td>
            </tr>';

    foreach (\App\FormIAR::where('modir_code', $data)->whereIn('exam_id', $exams)->get() as $key => $detail) {
        $number = $key + 1;
        $html .= '
                <tr>
                    <td style="text-align:center;">' . $number . '</td>
                    <td style="font-size:9px">' . \App\Modir::getExam($detail->exam_id) . '</td>
                    <td style="text-align:center;font-size:9px">' . $detail->mark . '</td>
                    <td style="font-size:9px">' . $detail->mark_nazm . '</td>
                    <td style="font-size:9px">' . $detail->mark_performance . '</td>
                    <td style="font-size:9px">' . \App\Exam::Hozor($detail->exam_id, $data) . '</td>
                </tr>';
    }

    $html .= '</table></div>';


    $html .= '<div style="width:100%;float:right;margin-top:20px">

         <table class="table table-bordered">
            <tr>
                <td style="font-size:13px">ردیف</td>
                <td style="font-size:13px">آیتم</td>
                <td style="font-size:13px;text-align:center">نمره کل </td>
                <td style="font-size:13px;text-align:center"> آزمون های </td>
            </tr>';

    foreach (\App\QuestionIar::where('status', 1)->get() as $key => $detail) {

        $number = $key + 1;
        if ($key == 0) {
            $html .= '
                <tr>
                    <td style="text-align:center;">' . $number . '</td>
                    <td style="font-size:9px">' . $detail->question . '</td>
                    <td style="text-align:center;font-size:9px">' . \App\Modir::getItemIarTotal($data, $exams, $detail->id) . ' از ' . $detail->mark . '</td>
                    <td style="text-align:center;font-size:9px">' . \App\Modir::getItemIarExam($data, $exams, $detail->id) . '</td>
                </tr>';
        } else {
            $html .= '
                <tr>
                    <td style="text-align:center;">' . $number . '</td>
                    <td style="font-size:9px">' . $detail->question . '</td>
                    <td style="text-align:center;font-size:9px">' . \App\Modir::getItemIarTotal($data, $exams, $detail->id) . ' از ' . $detail->mark . '</td>
                    <td style="text-align:center;font-size:9px"></td>
                </tr>';
        }

    }

    $html .= '</table></div>';


    $html .= '<div style="width:100%;float:right;margin-top:20px">

         <table class="table table-bordered">
            <tr>
                <td style="font-size:13px">ردیف</td>
                <td style="font-size:13px">نام پشتیبان</td>
                <td style="font-size:13px;text-align:center">میانگین نمره کل </td>
                <td style="font-size:13px;text-align:center"> تعداد آزمون </td>
            </tr>';

    $i = 1;
    $pos = [];
    foreach (\App\Mark::whereIn('exam_id', $exams)
                 ->where('modir_code', $data)
                 ->select('poshtiban_code', DB::raw('count(*) as totalexam'), DB::raw('avg(total) as meanperformance'))
                 ->groupBy('poshtiban_code')
                 ->orderBy('meanperformance', 'asc')
                 ->get() as $key => $poshtiban) {
        $html .= '
                <tr>
                    <td style="text-align:center;">' . $i . '</td>
                    <td style="font-size:9px">' . \App\Poshtiban::where('codemeli', $poshtiban->poshtiban_code)->first()['name'] . '</td>
                    <td style="text-align:center;font-size:9px">' . round($poshtiban->meanperformance, 1, PHP_ROUND_HALF_UP) . 'از 20</td>
                    <td style="text-align:center;font-size:9px">' . $poshtiban->totalexam . '</td>
                </tr>';
        $i += 1;
    }


    $html .= '</table></div>';

    $html .= '

            </div>
        </div>


    </div>';
    $html .= '<div class="header">

        <div class="col-md-6">
            <p>
                <span> توضیحات بازرس :  </span>
                <span></span >
            </p >

        </div >

        <div class="col-md-6" style = "text-align:left" >
        </div>
        <div style = "clear:both" ></div>
        <div style = "clear:both" ></div>
        <div style = "clear:both" ></div>
    </div>';

    $html .= '<div class="header">

        <div class="col-md-6">
            <p>
                <span> توضیحات مدیر :  </span>
                <span></span >
            </p >

        </div >

        <div class="col-md-6" style = "text-align:left" >
        </div>
        <div style = "clear:both" ></div>
        <div style = "clear:both" ></div>
        <div style = "clear:both" ></div>
    </div>';
$html .= '<div class="page-break"></div>';
}


use App\FormIAR;
use App\Modir;
use Mpdf\Output\Destination;

$mpdf = new \Mpdf\Mpdf();
$mpdf->allow_charset_conversion = true;
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents('assets/css/print/pdf_style.css');
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->SetDirectionality('rtl');
$mpdf->WriteHTML($html);
$mpdf->Output('file.pdf', Destination::DOWNLOAD);
?>
