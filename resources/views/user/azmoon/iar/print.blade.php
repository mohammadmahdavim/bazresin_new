<html>
<header>
    <meta charset="UTF-8">
    <title>پیش نمایش فرم IAR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('assets/css/print/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/print/bootstrap-rtl.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/print/print.css') }}" rel="stylesheet">
</header>

<body>


<div style="width:75%;margin:auto">

    <div style="text-align:center;padding-top:15px;padding-bottom:15px">
        <a href="{{ url('user/azmoon/iar/pdfPrint/'.$exam_id.'/'.$modir_code) }}"
           class="btn btn-default">فایل pdf فرم IAR</a>
    </div>

    <div class="header">

        <div class="col-md-6">
            <p>
                <span> نام حوزه :  </span>
                <span>{{getHozeh($data->hozeh_code)['name']}}</span>
            </p>
            <p>
                <span>نام مسئول حوزه :  </span>
                <span>{{getModir($modir_code)['name']}}</span>
            </p>
            <p>
                <span>تاریخ آزمون و ثبت فرم: </span>
                <span>{{$data->date}}</span>
            </p>
        </div>

        <div class="col-md-6" style="text-align:left">
            <p>
                <span>نام بازرس : </span>
                <span>{{getBazres($data->bazres_code)['name']}}</span>
            </p>
            <p>
                <span>منطقه : </span>
                <span>{{getHozeh($data->hozeh_code)['zone']}}</span>
            </p>
        </div>


        <div style="clear:both"></div>
    </div>





    <div style="width:100%;float:right;margin-top:20px">

        <table class="table table-bordered" style="font-size:13px">

            <th>شرح فعالیت اجرایی</th>
            <th>امتیاز کنترل</th>
            <th>شرح و کامنت بازرس</th>
            @foreach($details as $detail)
                <tr>
                    <td>{{getQuestion($detail->question_id)}}</td>
                    <td>{{$detail->mark}}</td>
                    <td>
                        {{getGozineh($detail->description)}}
                    </td>
                </tr>
            @endforeach


        </table>

    </div>



    <div style="width:100%;float:right;margin-top:20px">

        <table class="table table-bordered" style="font-size:13px">

            <th>سوالات تشریحی</th>
            <th>توضیحات</th>

            <tr>
                <td>مدیر غائب</td>
                <td>{{$data->modir_ghaeyb}}</td>
            </tr>

            <tr>
                <td>مدیر متأخر</td>
                <td>{{$data->modir_moteakher}}</td>
            </tr>

            <tr>
                <td>پشتیبان غائب</td>
                <td>{{$data->poshtiban_ghaeyb}}</td>
            </tr>


            <tr>
                <td>پشتیبان متأخر</td>
                <td>{{$data->poshtiban_moteakher}}</td>
            </tr>


            <tr>
                <td>اسامی پشتیبان های آموزشی</td>
                <td>{{$data->poshtiban_amozeshi}}</td>
            </tr>


            <tr>
                <td>شاخص ترین نقطه قوت حوزه در این آزمون چه بود؟</td>
                <td>{{$data->shakhes_ghovat}}</td>
            </tr>


            <tr>
                <td>مهم ترین عامل اختلال در نظم حوزه را چه می دانید؟</td>
                <td>{{$data->ekhtelal_nazm}}</td>
            </tr>


            <tr>
                <td>به طور کلی ارزیابی شما در خصوص عملکرد اجرایی، کمی و کیفی در این حوزه چیست؟</td>
                <td>{{$data->arzyabi}}</td>
            </tr>

        </table>

    </div>

    <div style="width:100%;float:right;margin-top:20px">

        <div class="product_row">
            <div class="col-md-3" style="text-align: center;margin-top: 10px">
                <span style="margin-top: 10px">امضا مدیر</span>
                <img class="cart_img" src="{{ url('assets/signature-image/'.$data->img_signature) }}">

            </div>

            <div class="col-md-3" style="text-align: center;margin-top: 10px">

                <span style="margin-top: 10px">امضا بازرس</span>
                <img class="cart_img" src="{{ url('assets/signature-image/bazres/'.$data->img_signature_bazres) }}">
            </div>

            <div class="col-md-6">
                <p style="padding-top:20px">شرح وضعیت</p>

                <p style="color:#777">
                    <span>رنگ بازرس به نظم حوزه : </span>
                    <span>
                        @if($data->mark_nazm == 5)
                            آبی
                        @elseif($data->mark_nazm == 4)
                            سبز پر رنگ
                        @elseif($data->mark_nazm == 3)
                            سبز
                        @elseif($data->mark_nazm == 2)
                            زرد
                        @elseif($data->mark_nazm == 1)
                            قرمز
                        @else
                            مشکی
                        @endif
                    </span>
                </p>


                <p style="color:#777">
                    <span>رنگ  به کارهای کیفی حوزه : </span>
                    <span>
                        @if($data->mark_performance == 5)
                            آبی
                        @elseif($data->mark_performance == 4)
                            سبز پر رنگ
                        @elseif($data->mark_performance == 3)
                            سبز
                        @elseif($data->mark_performance == 2)
                            زرد
                        @elseif($data->mark_performance == 1)
                            قرمز
                        @else
                            مشکی
                        @endif
                    </span>
                </p>

                <p style="color:#777">
                    <span>  امتیاز کل : </span>
                    <span style="padding-top:20px">{{$data->mark}}</span>
                </p>
            </div>
        </div>


    </div>

</div>

</body>

</html>
@php
    function getQuestion($question_id){
        $question = \App\QuestionIar::find($question_id);
        return $question->question;
    }

    function getGozineh($description){
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

    function getHozeh($hozeh_code){
        $hozeh = \App\Hozeh::where('code',$hozeh_code)->first();
        return $hozeh;
    }

    function getModir($modir_code)
    {
        $modir = \App\Modir::where('codemeli',$modir_code)->first();
        return $modir;
    }

    function getBazres($bazres_code)
    {
        $bazres = \App\Bazres::where('codemeli',$bazres_code)->first();
        return $bazres;
    }
@endphp
