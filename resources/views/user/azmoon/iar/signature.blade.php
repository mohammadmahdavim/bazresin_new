@extends('layouts.UserLayouts')

@section('script')
    <script src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_select2.js"></script>
    <style>
        #btnSaveSign {
            color: #fff;
            background: #f99a0b;
            padding: 5px;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            margin-top: 10px;
        }

        #signArea {
            width: 234px;
            margin: 15px auto;
        }

        #signArea1 {
            width: 234px;
            margin: 15px auto;
        }

        .sign-container {
            width: 90%;
            margin: auto;
        }

        .sign-preview {
            width: 234px;
            height: 50px;
            border: solid 1px #CFCFCF;
            margin: 10px 5px;
        }

        .tag-ingo {
            font-size: 12px;
            text-align: left;
            font-style: oblique;
        }

        .center-text {
            text-align: center;
        }
    </style>

    <link href="/assets/signatur/css/jquery.signaturepad.css" rel="stylesheet">

    <script src="/assets/signatur/js/numeric-1.2.6.min.js"></script>
    <script src="/assets/signatur/js/bezier.js"></script>
    <script src="/assets/signatur/js/jquery.signaturepad.js"></script>
    <script src="/assets/signatur/js/json2.min.js"></script>

    <script src="/assets/signatur/js/bootstrap-select.js"></script>



    <script type='text/javascript' src="/assets/signatur/js/html2canvas.js"></script>
    <script>
        save_iar = function (type) {
            Swal.fire({
                title: 'صبر کنید ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            event.preventDefault();
            jQuery.noConflict();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var canvas = document.getElementById('canvas');
            var dataURL = canvas.toDataURL();
            var form = $("form").serializeArray() + dataURL;
            //ajax call to save image inside folder
            $.ajax({
                url: '{{url('/user/ajaxSaveIar')}}',
                data: form,
                type: 'POST',
                success: function (data) {
                    if (!data.errors) {
                        swal.close();
                        $("#alert_show").hide();
                        Swal.fire({
                            type: 'success',
                            title: 'با موفقیت ثبت گردید',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        $("#alert_show").html('');
                        jQuery.each(data.errors, function (key, value) {
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>' + value + '</p>');
                        });
                        swal.close();
                    }

                },
            });
        };
    </script>

    <script>
        $(document).ready(function (e) {

            $(document).ready(function () {
                $('#signArea').signaturePad({drawOnly: true, drawBezierCurves: true, lineTop: 150});
            });

            $("#removeSaveSign").click(function (e) {
                $('#signArea').signaturePad().clearCanvas();
            });


            $(document).ready(function () {
                $('#signArea1').signaturePad({drawOnly: true, drawBezierCurves: true, lineTop: 150});
            });

            $("#removeSaveSign1").click(function (e) {
                $('#signArea1').signaturePad().clearCanvas();
            });
        });
    </script>




    <script>
        $(document).on("click", ".submitIar", function () {
            var id = $(this).data('id');
            var el = this;

            Swal.fire({
                title: 'از ثبت مطمئن هستید؟',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00a018',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    var canvas = document.getElementById('canvas');
                    var dataURL = canvas.toDataURL();

                    var canvas1 = document.getElementById('canvas1');
                    var dataURL1 = canvas1.toDataURL();
                    var formIar = $('#formIar').serialize();


                    $.ajax({
                        url: '{{url('/user/ajaxSaveSignature')}}',
                        type: 'POST',
                        data: {
                            "img_signature": dataURL,
                            "img_signature_bazres": dataURL1,
                            "_token": '{{csrf_token()}}',
                            "exam_id": '{{$exam_id}}',
                            "modir_code": '{{$modir_code}}',
                            "formIar": formIar
                        },

                        success: function (data) {
                            if (data == 'ok') {
                                Swal.fire(
                                    'موفق',
                                    'ثبت نهایی شد',
                                    'success'
                                );
                                window.location.replace("{{url('/user/azmoon/modir/'.$exam_id)}}");
                            } else {
                                Swal.fire(
                                    'خطا',
                                    data.errors,
                                    'error'
                                )
                            }
                        }
                    });
                }
            });
        });

    </script>


    <script type="text/javascript"
            src="<?= url('assets/js/core/libraries/jquery_ui/interactions.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= url('assets/js/plugins/forms/selects/select2.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/selectboxit.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>"></script>
    <script>
        $(function () {


            // Selects
            // ------------------------------

            // Multiselect
            $('.multiselect').multiselect({
                buttonWidth: '100%'
            });

            //tags support
            $('.select-multiple-tags').select2({
                tags: true
            });

            // SelectBoxIt selects
            $(".selectbox").selectBoxIt({
                autoWidth: false
            });


            // Select2 basic
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection

@section('content')
    <!-- Solid tabs title -->
    <h6 class="content-group text-semibold">
        فرم ارزشیابی IAR
    </h6>
    <!-- /solid tabs title -->


    <!-- Tabs with solid background -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <small class="display-block">ابتدا سوالات زیر را پاسخ داده و پس از امضای بازرس، نمره کلی بازرسی را
                        به مدیر نشان داده و نقاط ضعف و قوت را به آنها یاد آوری نمایید. سپس مدیر امضا نماید.
                    </small>
                </div>

                <div class="panel-body">
                    <!-- Colored table options -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title">سوالات</h5>
                        </div>
                        <form id="formIar" onsubmit="return false;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover bg-defulte-700">
                                    <tbody>
                                    <tr>
                                        <td>مدیر غائب</td>
                                        <td>
                                            <select data-placeholder="گزینه ای انتخاب یا تایپ نمایید"
                                                    name="modir_ghayeb[]"
                                                    multiple="multiple"
                                                    class="select-multiple-tags select-lg">
                                                @foreach(getModirs($exam_id,auth()->user()->codemeli) as $modir)
                                                    <option value="{{$modir->modir}}">{{App\lib\EnConverter::ar2fa($modir->modir)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>مدیر متأخر</td>
                                        <td>
                                            <select data-placeholder="گزینه ای انتخاب یا تایپ نمایید"
                                                    name="modir_moteakher[]"
                                                    multiple="multiple"
                                                    class="select-multiple-tags select-lg">
                                                @foreach(getModirs($exam_id,auth()->user()->codemeli) as $modir)
                                                    <option value="{{$modir->modir}}">{{App\lib\EnConverter::ar2fa($modir->modir)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>پشتیبان غائب</td>
                                        <td>
                                            <select data-placeholder="گزینه ای انتخاب یا تایپ نمایید"
                                                    name="poshtiban_ghayeb[]"
                                                    multiple="multiple"
                                                    class="select-multiple-tags select-lg">
                                                @foreach(getPoshtibans($exam_id,auth()->user()->codemeli) as $poshtiban)
                                                    <option value="{{$poshtiban->poshtiban}}">{{App\lib\EnConverter::ar2fa($poshtiban->poshtiban)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>پشتیبان متأخر</td>
                                        <td>
                                            <select data-placeholder="گزینه ای انتخاب یا تایپ نمایید"
                                                    name="poshtiban_moteakher[]"
                                                    multiple="multiple"
                                                    class="select-multiple-tags select-lg">
                                                @foreach(getPoshtibans($exam_id,auth()->user()->codemeli) as $poshtiban)
                                                    <option value="{{$poshtiban->poshtiban}}">{{App\lib\EnConverter::ar2fa($poshtiban->poshtiban)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>اسامی پشتیبان آموزشی</td>
                                        <td>
                                            <select data-placeholder="نام هر پشتیبان را درج نمایید"
                                                    name="poshtiban_amozeshi[]"
                                                    multiple="multiple"
                                                    class="select-multiple-tags select-lg">

                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>شاخص ترین نقطه قوت حوزه <span style="color: red">*</span></td>
                                        <td>
                                        <textarea class="form-control" name="shakhes_ghovat" rows="4"
                                                  placeholder="توضیحی درج نمایید..."></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>مهم ترین عامل اختلال در نظم حوزه <span style="color: red">*</span></td>
                                        <td>
                                        <textarea class="form-control" name="ekhtelal_nazm" rows="4"
                                                  placeholder="توضیحی درج نمایید..."></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>ارزیابی کلی شما <span style="color: red">*</span></td>
                                        <td>
                                        <textarea class="form-control" name="arzyabi" rows="4"
                                                  placeholder="توضیحی درج نمایید..."></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>رنگ بازرس به نظم حوزه <span style="color: red">*</span></td>
                                        <td>
                                            <select name="mark_nazm"
                                                    class="form-control" required>
                                                <option value="">انتخاب کنید</option>
                                                <option value="0">مشکی</option>
                                                <option value="1">قرمز</option>
                                                <option value="2"> زرد</option>
                                                <option value="3">سبز</option>
                                                <option value="4">سبزپررنگ</option>
                                                <option value="5">آبی</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>رنگ بازرس به کار های کیفی حوزه <span style="color: red">*</span></td>
                                        <td>
                                            <select name="mark_performance"
                                                    class="form-control" required>
                                                <option value="">انتخاب کنید</option>
                                                <option value="0">مشکی</option>
                                                <option value="1">قرمز</option>
                                                <option value="2"> زرد</option>
                                                <option value="3">سبز</option>
                                                <option value="4">سبزپررنگ</option>
                                                <option value="5">آبی</option>
                                            </select>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="panel-body">
                            <div class="tab-pane">
                                <div class="col-lg-3" align="center">
                                    <div id="signArea1">
                                        <h2 class="tag-ingo" style="text-align: right">در این کادر بایستی امضای بازرس
                                            قرار گیرد.</h2>
                                        <div class="sig sigWrapper" style="height:auto;">
                                            <div class="typed"></div>
                                            <canvas class="sign-pad" id="canvas1" width="230"
                                                    height="230"></canvas>
                                        </div>
                                    </div>
                                    <button id="removeSaveSign1" class="btn btn-danger"><i class="icon-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /colored table options -->
                    <!-- Custom row colors -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> نمره نهایی مدیر {{$iar->mark}} از 100 نمره </h5>
                        </div>


                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>آیتم</th>
                                    <th>امتیاز</th>
                                    <th>توضیحات</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($answers as $answer)
                                    <tr
                                        @if($answer->mark == 2)
                                        class="bg-orange"
                                        @elseif($answer->mark == 1)
                                        class="bg-danger"
                                        @elseif($answer->mark == 0)
                                        class="bg-brown"
                                        @endif

                                    >
                                        <td>{{getQuestion($answer->question_id)}}</td>
                                        <td>{{$answer->mark}}</td>
                                        <td>{{getGozineh($answer->description)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /custom row colors -->

                    <div class="tab-pane">
                        <div class="col-lg-3" align="center">
                            <div id="signArea">
                                <h2 class="tag-ingo" style="text-align: right">در این کادر بایستی امضای مدیر
                                    قرار گیرد.</h2>
                                <div class="sig sigWrapper" style="height:auto;">
                                    <div class="typed"></div>
                                    <canvas class="sign-pad" id="canvas" width="230"
                                            height="230"></canvas>
                                </div>
                            </div>
                            <button id="removeSaveSign" class="btn btn-danger"><i class="icon-trash"></i>
                            </button>

                            <a class="btn btn-success submitIar"><i class="icon-check2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /tabs with solid background -->
@stop

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

    function getModirs($exam_id,$codemeli)
    {
        $modirs = \Illuminate\Support\Facades\DB::table('exam'.$exam_id)
        ->where('bazres_code',$codemeli)
        ->select('modir', DB::raw('count(*) as total'))
        ->groupBy('modir')
        ->get();
        return $modirs;
    }

    function getPoshtibans($exam_id,$codemeli)
    {
        $poshtibans = \Illuminate\Support\Facades\DB::table('exam'.$exam_id)
        ->where('bazres_code',$codemeli)
        ->select('poshtiban', DB::raw('count(*) as total'))
        ->groupBy('poshtiban')
        ->get();
        return $poshtibans;
    }
@endphp
