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
  </style>
<div class="header">

        <div class="col-md-6">
            <p>
                <span> نام حوزه :  </span>
                <span>' . getHozeh($data->hozeh_code)['name'] . ' </span >
            </p >
            <p >
                <span > نام مسئول حوزه :  </span >
                <span >' . getModir($modir_code)['name'] . '</span>
            </p>
            <p>
                <span > تاریخ آزمون و ثبت فرم: </span >
                <span >' . $data->date . '</span >
            </p >
        </div >

        <div class="col-md-6" style = "text-align:left" >
            <p >
                <span> نام بازرس : </span>
                <span>' . getBazres($data->bazres_code)['name'] . '</span>
            </p>
            <p>
                <span> منطقه : </span>
                <span>' . getHozeh($data->hozeh_code)['zone'] . '</span >
            </p >
        </div>
        <div style = "clear:both" ></div>
    </div>';


$html .= '<div style="width:100%;float:right;margin-top:20px">

         <table class="table table-bordered">
            <tr>
                <td style="font-size:13px">ردیف</td>
                <td style="font-size:13px">شرح فعالیت اجرایی</td>
                <td style="font-size:13px;text-align:center">امتیاز کنترل</td>
                <td style="font-size:13px">شرح و کامنت بازرس</td>
            </tr>';

foreach ($details as $key => $detail) {
    $number = $key + 1;
    $html .= '
                <tr>
                    <td style="text-align:center;">' . $number . '</td>
                    <td style="font-size:9px">' . getQuestion($detail->question_id) . '</td>
                    <td style="text-align:center;font-size:9px">' . $detail->mark . '</td>
                    <td style="font-size:9px">' . getGozineh($detail->description) . '</td>
                </tr>';
}

$html .= '</table></div>';

$html .= '
              <div style="width:100%;float:right;margin-top:20px">

         <table class="table table-bordered">

            <tr>
                <td style="font-size:13px">سوالات تشریحی</td>
                <td style="font-size:13px">توضیحات</td>
            </tr>

            <tr>
                <td>مدیر غائب</td>
                <td>' . $data->modir_ghayeb . '</td>
            </tr>

            <tr>
                <td>مدیر متأخر</td>
                <td>' . $data->modir_moteakher . '</td>
            </tr>

            <tr>
                <td>پشتیبان غائب</td>
                <td>' . $data->poshtiban_ghayeb . '</td>
            </tr>


            <tr>
                <td>پشتیبان متأخر</td>
                <td>' . $data->poshtiban_moteakher . '</td>
            </tr>


            <tr>
                <td>اسامی پشتیبان های آموزشی</td>
                <td>' . $data->poshtiban_amozeshi . '</td>
            </tr>


            <tr>
                <td>شاخص ترین نقطه قوت حوزه در این آزمون چه بود؟</td>
                <td>' . $data->shakhes_ghovat . '</td>
            </tr>


            <tr>
                <td>مهم ترین عامل اختلال در نظم حوزه را چه می دانید؟</td>
                <td>' . $data->ekhtelal_nazm . '</td>
            </tr>


            <tr>
                <td>به طور کلی ارزیابی شما در خصوص عملکرد اجرایی، کمی و کیفی در این حوزه چیست؟</td>
                <td>' . $data->arzyabi . '</td>
            </tr>

        </table>

    </div>
';

$html .= '    <div style="width:100%;float:right;margin-top:20px">

        <div class="product_row">
            <div class="col-md-3" style="text-align: center;margin-top: 10px">
                <span style="margin-top: 10px">امضا مدیر</span>
                <img class="cart_img" src="' . url('assets/signature-image/' . $data->img_signature) . '">

            </div>

            <div class="col-md-3" style="text-align: center;margin-top: 10px">
                <span style="margin-top: 10px">امضا بازرس</span>
                <img class="cart_img" src="' . url('assets/signature-image/bazres/' . $data->img_signature_bazres) . '">

            </div>

            <div class="col-md-4">
                <p style="padding-top:20px">شرح وضعیت</p>

                <p style="color:#777">
                    <span>رنگ بازرس به نظم حوزه : </span>
                    <span>';
if ($data->mark_nazm == 5) {
    $html .= 'آبی';
} elseif ($data->mark_nazm == 4) {
    $html .= 'سبز پر رنگ';
} elseif ($data->mark_nazm == 3) {
    $html .= 'سبز';
} elseif ($data->mark_nazm == 2) {
    $html .= 'زرد';
} elseif ($data->mark_nazm == 1) {
    $html .= 'قرمز';
} else {
    $html .= 'مشکی';
}
$html .= '</span>
                </p>


                <p style="color:#777">
                    <span>رنگ  به کارهای کیفی حوزه : </span>
                    <span>';
if ($data->mark_performance == 5) {
    $html .= 'آبی';
} elseif ($data->mark_performance == 4) {
    $html .= 'سبز پر رنگ';
} elseif ($data->mark_performance == 3) {
    $html .= 'سبز';
} elseif ($data->mark_performance == 2) {
    $html .= 'زرد';
} elseif ($data->mark_performance == 1) {
    $html .= 'قرمز';
} else {
    $html .= 'مشکی';
}
$html .= '</span>
                </p>

                <p style="color:#777">
                    <span>  امتیاز کل : </span>
                    <span style="padding-top:20px">' . $data->mark . '</span>
                </p>

            </div>



        </div>


    </div>';


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
