@extends('layouts.UserLayouts')

@section('css')
    <meta name="_token" content="{{ csrf_token() }}"/>
@stop
@section('script')
    <script type="text/javascript"
            src="<?= url('assets/js/core/libraries/jquery_ui/interactions.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= url('assets/js/plugins/forms/selects/select2.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/selectboxit.min.js'); ?>"></script>
    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>"></script>

    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>
    <script>
        $(function () {

            // Init with empty values
            $(".touchspin-empty-limit").TouchSpin({
                min: 0,
                max: {{$data->total_student}},
                step: 1,
                decimals: 0,
            });

            $(".touchspin-empty-limit-2").TouchSpin({
                min: 0,
                max: 2,
                step: 1,
                decimals: 0,
            });
            // Selects
            // ------------------------------

            // Multiselect
            $('.multiselect').multiselect({
                buttonWidth: '100%'
            });

            // SelectBoxIt selects
            $(".selectbox").selectBoxIt({
                autoWidth: false
            });


            // Select2 basic
            $('.select').select2({
                minimumResultsForSearch: Infinity
            });

            // Custom results color
            $('.select-results-color').select2({
                containerCssClass: 'bg-teal-400',
                tags: true
            });

        });
    </script>

    <script>
        save_bazresi = function () {

            var selector = document.getElementById('vaziat');
            var vaziat = selector[selector.selectedIndex].value;

            if (vaziat == 10) {
                swal.fire({
                    title: 'هشدار',
                    type: 'warning',
                    text: 'وضعیت بازرسی را مشخص کنید'
                });
                return false;
            }

            Swal.fire({
                title: 'در حال ثبت ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });


            var data = $('#bazresiForm').serialize();

            $.ajax({
                url: '{{url('/user/azmoon/'.$data->id)}}',
                type: 'POST',
                data: data,
                success: function (response) {
                    if (response.status === 200) {
                        swal.fire({
                            title: 'موفق',
                            type: 'success',
                            text: 'ذخیره شد'
                        });
                        setTimeout(function () {
                            window.location.replace('{{url('/user/azmoon/'.$azmoon->id)}}');
                        }, 2000);
                    } else if (response.status === 401) {
                        swal.fire({
                            title: 'توجه',
                            type: 'warning',
                            text: 'برخی آیتم ها پر نشده اند'
                        });
                        $('#alert_show').html('');
                        jQuery('.alert-danger').append('<p>پر کردن این فیلد ها الزامی است</p>');
                        jQuery.each(response.errors, function (key, value) {
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<li>' + value + '</li>');
                        });
                    } else {
                        swal.fire({
                            title: 'خطا',
                            type: 'error',
                            text: 'خطایی رخ داد! دوباره ثبت نمایید'
                        });
                        swal.close();
                    }
                }
            });

        }
    </script>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-flat">
            <div class="panel-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-top nav-justified">
                        <li class="active">
                            <a href="#justified-icon-only-tab1" data-toggle="tab">
                                <i class="icon-list3"></i>
                                <span class="visible-xs-inline-block position-right">فرم</span>
                            </a>
                        </li>

                        <li>
                            <a href="#justified-icon-only-tab2" data-toggle="tab">
                                <i class="icon-history"></i>
                                <span class="visible-xs-inline-block position-right">تاریخچه</span>
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="justified-icon-only-tab1">
                            <!-- Table components -->
                            <form id="bazresiForm" onsubmit="save_bazresi();return false;" method="post">
                                <input type="hidden" name="azmoon_id" value="{{$azmoon->id}}">
                                <fieldset class="content-group">
                                    <legend class="text-bold"> پشتیبان : {{$data->poshtiban}} </legend>

                                    <?php $k = 1; ?>
                                    @foreach( getcolum($azmoon->id) as $key=>$column )
                                        @if( $header->$column == "")
                                        @else
                                            @foreach( $type_select as $type )
                                                @if($type->$column != "6")
                                                    <div class="form-group">
                                                        <span class="help-block">{{$k}}- </span>
                                                        <label
                                                            class="control-label col-sm-4"
                                                            style="font-weight: bold"> {{$header->$column}} @if(getRequired($column,$azmoon->id) == 1)
                                                                <span style="color: red">*</span>
                                                                @if(array_key_exists($column,$tooltip))
                                                                    <a data-popup="tooltip"
                                                                       title="{{round($tooltip[$column], 1, PHP_ROUND_HALF_UP)}}  از {{$tooltip[$column.'0mark']}} نمره -  در طی {{$tooltip['exams']}}  آزمون. @if($old != null) نمره آزمون قبل {{$old->$column}} @endif"
                                                                       data-placement="bottom" id="left"><i
                                                                            class="icon-question3"
                                                                            style="color: @if(round($tooltip[$column], 1, PHP_ROUND_HALF_UP) >= 0.75*$tooltip[$column.'0mark']) blue @elseif(round($tooltip[$column], 1, PHP_ROUND_HALF_UP) >= 0.5*$tooltip[$column.'0mark']) green @elseif(round($tooltip[$column], 1, PHP_ROUND_HALF_UP) >= 0.25*$tooltip[$column.'0mark']) yellow @else red @endif"></i></a>
                                                                @endif

                                                            @endif</label>
                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                @if( $type->$column == "0" )
                                                                    @if($column == 'total_student' )
                                                                        <input type="number" name="{{ $column }}"
                                                                               value="{{$data->$column}}"
                                                                               class="touchspin-empty">
                                                                    @else
                                                                        <input type="text" class="form-control"
                                                                               readonly="readonly"
                                                                               value="{{$data->$column}}">

                                                                    @endif

                                                                @elseif( $type->$column == "2" )
                                                                    <select class="select"
                                                                            name="{{ $column }}">
                                                                        <option value="">انتخاب کنید</option>
                                                                        @foreach(  $select as $single_select )
                                                                            @if($single_select->$column == "" )
                                                                            @else
                                                                                <option
                                                                                    value="{{ $single_select->$column }}"
                                                                                    @if ($data->$column ==  $single_select->$column) selected="selected" @endif >{{ $single_select->$column }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                @elseif($type->$column == "3")
                                                                    <div class="input-group">
											                        <span class="input-group-btn">
												                        <button class="btn btn-default btn-icon"
                                                                                type="button"><i
                                                                                class="icon-select2"></i></button>
                                                                    </span>
                                                                        <select name="{{ $column }}[]"
                                                                                multiple="multiple"
                                                                                class="select-results-color">
                                                                            @foreach(  $select as $single_select )
                                                                                @if($single_select->$column == "" )
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $single_select->$column }}"
                                                                                        @if (in_array($single_select->$column,explode(" - ",$data->$column))) selected @endif>{{ $single_select->$column }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>


                                                                @elseif($type->$column == "1")
                                                                    <input name="{{ $column }}" class="form-control"
                                                                           value="{{$data->$column}}"
                                                                           placeholder="بنویسید...">
                                                                @elseif($type->$column == "4")

                                                                    @if($column == 'extera_mark')
                                                                        <input type="number" name="{{ $column }}"
                                                                               value="{{($data->$column != 0 ? $data->$column : 0)}}"
                                                                               class="touchspin-empty-limit-2">
                                                                    @else
                                                                        <input type="number" name="{{ $column }}"
                                                                               value="{{($data->$column != 0 ? $data->$column : 0)}}"
                                                                               class="touchspin-empty-limit">
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <?php $k += 1; ?>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <div class="form-group">
                                        <span class="help-block"> {{$k + 1}}-</span>
                                        <label class="form-label col-sm-4" style="font-weight: bold">وضعیت
                                            پشتیبان</label>
                                        <div class="col-sm-8">
                                            <select name="vaziat" class="select select-sm" id="vaziat">
                                                <option value="10"
                                                        @if ($data->status == 10) selected="selected" @endif>
                                                    انتخاب
                                                    کنید
                                                </option>
                                                <option value="1"
                                                        @if ($data->status == 1) selected="selected" @endif >
                                                    موفق
                                                </option>
                                                <option value="2"
                                                        @if ($data->status == 2) selected="selected" @endif>
                                                    بازدید مجدد
                                                </option>
                                                <option value="3"
                                                        @if ($data->status == 3) selected="selected" @endif>
                                                    غائب
                                                </option>
                                                <option value="4"
                                                        @if ($data->status == 4) selected="selected" @endif> قطع
                                                    همکاری
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>

                                <!-- /table components -->
                                <!-- Button options -->
                                <div class="row">

                                    <div class="alert alert-danger" style="display:none" id="alert_show"></div>
                                    <div class="panel panel-body border-top-primary text-center">
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group col-md-3">
                                                <a class="btn btn-success bg-slate-700"
                                                   onclick="save_bazresi()">ثبت
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /button options -->

                            </form>
                        </div>
                        <div class="tab-pane" id="justified-icon-only-tab2">
                            <!-- Dashed border styling -->
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h5 class="panel-title">{{$data->poshtiban}}</h5>
                                    <div class="heading-elements">
                                        <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="reload"></a></li>
                                            <li><a data-action="close"></a></li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>آزمون</th>
                                            <th>تاریخ</th>
                                            <th>نام بازرس</th>
                                            <th> نمره</th>
                                            <th>هدف گذاری ها</th>
                                            <th>نقاط ضعف</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @if(count($histories) == 0)
                                            <tr>
                                                <td colspan="7" style="text-align: center">
                                                    هیچ تاریخچه ای موجود نیست
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach($histories as $key=>$history)
                                            <tr class="border-dashed">
                                                <td>{{$key+1}}</td>
                                                <td>{{getExam($history->exam_id)->name}}</td>
                                                <td>{{$history->date}}</td>
                                                <td>{{getBazres($history->bazres_code)}}</td>
                                                <td>
                                                    <span
                                                        @if($history->quality_performance_mark >= 16)
                                                        class="label label-primary"
                                                        @elseif($history->quality_performance_mark >= 12 && $history->quality_performance_mark < 16)
                                                        class="label label-success bg-green-800"
                                                        @elseif($history->quality_performance_mark >= 8 && $history->quality_performance_mark < 12)
                                                        class="label label-success"
                                                        @elseif($history->quality_performance_mark >= 4 && $history->quality_performance_mark < 8)
                                                        class="label label-warning"
                                                        @elseif($history->quality_performance_mark < 4)
                                                        class="label label-danger"
                                                        @else
                                                        class="label label-block"
                                                            @endif
                                                    >{{$history->quality_performance}}</span>
                                                </td>
                                                <td>
                                                    @foreach(explode(',',$history->targets) as $target)
                                                        <span class="label label-info">{{$target}}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach(explode(',',$history->debility) as $debility)
                                                        <span class="label label-warning">{{$debility}}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if(array_sum($losses) > 0)
                            <!-- Basic bar chart -->
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title"> در طی {{$losses['exams']}} آزمون اخیر {{array_sum($losses)}} از {{number_format($losses['exams'] * 20)}} نمره از دست داده اید.</h6>
                                </div>
                                <div class="panel-body">
                                    <div class="chart-container has-scroll">
                                        <div class="chart has-fixed-height has-minimum-width" id="container4"></div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- /basic bar chart -->


                            <!-- /dashed border styling -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /icons only -->


    @if(array_sum($losses) > 0)
    <script type="text/javascript" src="{{ url('assets/js/highcharts.js') }}"></script>
    <script>
        Highcharts.chart('container4', {
            chart: {
                type: 'pie',
                style: {
                    fontFamily: 'IRANSans-web'
                }
            },
            title: {
                text: 'نمرات از دست رفته'
            },
            tooltip: {
                useHTML: true,
                pointFormat: '<b>{point.percentage:.1f}%</b><br>نمره: {point.y} </br>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        y: -5, //Optional
                        format: '\u202B' + '{point.name}', // \u202B is RLE char for RTL support
                        style: {
                            fontSize: '15px',
                            fontFamily: 'IRANSans-web',
                            textShadow: false, //bug fixed IE9 and EDGE
                        },
                        useHTML: true,
                    },
                    //showInLegend: true,
                },
            },
            series: [{
                name: 'percent',
                colorByPoint: true,
                data: [
                        @foreach( getcolum($azmoon->id) as $key=>$column )
                        @if(array_key_exists($column,$losses))
                    {
                        name: '{{$translates[$column]}}',
                        y: {{$losses[$column]}}
                    },
                    @endif
                    @endforeach]
            }]
        });
    </script>
    @endif

@stop


<?php
function getcolum($id_project)
{
    $table_col = DB::getSchemaBuilder()->getColumnListing('exam' . $id_project);
    $remove = ["id", "author", "bazres_code", "modir_code", "modir_mobile", "poshtiban_mobile", "poshtiban_code", "type"];
    $table_col = \array_diff($table_col, $remove);

    return $table_col;
}

function getBazres($bazres_code)
{
    $bazres = \App\Bazres::where('codemeli', 'LIKE', '%' . $bazres_code . '%')->first();
    if ($bazres == null) {
        return 'بدون نام';
    }
    return $bazres->name;
}

function getExam($id)
{
    $exam = \App\Exam::find($id);
    return $exam;
}

function getRequired($column, $id)
{
    $required = \Illuminate\Support\Facades\DB::table('exam' . $id)
        ->where('type', 4)
        ->first();
    if ($required != null) {
        return $required->$column;
    }

    return false;
}
?>
