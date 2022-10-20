@extends('layouts.UserLayouts')

@section('script')

    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= url('assets/js/pages/form_bootstrap_select.js'); ?>"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>
    <script type="text/javascript" src="{{ url('assets/js/highcharts.src.js') }}"></script>
    <meta name="_token" content="{{csrf_token()}}">
@stop

@section('content')
    <!-- Main sidebar -->
    <div class="sidebar sidebar-main sidebar-default sidebar-separate">
        <div class="sidebar-content">

            <!-- User details -->
            <div class="content-group">
                <div class="panel-body bg-indigo-400 border-radius-top text-center"
                     style="background-image: url(http://demo.interface.club/limitless/assets/images/bg.png); background-size: contain;">
                    <div class="content-group-sm">
                        <h6 class="text-semibold no-margin-bottom">
                            {{$poshtiban->name}}
                        </h6>

                        <span class="display-block">پشتیبان</span>
                    </div>

                    <a href="#" class="display-inline-block content-group-sm">
                        <img src="{{url('assets/images/placeholder.jpg')}}" class="img-circle img-responsive" alt=""
                             style="width: 110px; height: 110px;">
                    </a>

                    <ul class="list-inline list-inline-condensed no-margin-bottom">
                        <li><i class="fa fa-star-o"></i></li>
                    </ul>
                </div>

                <div class="panel no-border-top no-border-radius-top">
                    <ul class="navigation">
                        <li class="navigation-header">گزارش ها</li>
                        <li class="active"><a href="#profile" data-toggle="tab"><i class="icon-files-empty"></i> عملکرد
                                کلی</a></li>
                        <li><a href="#schedule" data-toggle="tab"><i class="icon-files-empty"></i> عملکرد آزمون محور</a>
                        </li>
                        <li><a href="#comment" data-toggle="tab"><i class="icon-files-empty"></i> کامنت ها و هدف گذاری
                                ها</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /user details -->

        </div>
    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Tab content -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="profile">

                <!-- Daily stats -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">عملکرد کلی</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
                        </div>

                        <!-- Share your thoughts -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">هدف گذاری ها</h6>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="reload"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                <form action="#">
                                    <div class="form-group">
                                        <textarea name="enter-message" class="form-control mb-15" rows="3" cols="1" placeholder="What's on your mind?"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <ul class="icons-list icons-list-extended mt-10">
                                                <li><a href="#" data-popup="tooltip" title="Add photo" data-container="body"><i class="icon-images2"></i></a></li>
                                                <li><a href="#" data-popup="tooltip" title="Add video" data-container="body"><i class="icon-film2"></i></a></li>
                                                <li><a href="#" data-popup="tooltip" title="Add event" data-container="body"><i class="icon-calendar2"></i></a></li>
                                            </ul>
                                        </div>

                                        <div class="col-xs-6 text-right">
                                            <button type="button" class="btn btn-primary btn-labeled btn-labeled-right">Share <b><i class="icon-circle-left2"></i></b></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /share your thoughts -->
                    </div>
                </div>
                <!-- /daily stats -->
            </div>

            <div class="tab-pane fade" id="schedule">

                <!-- Available hours -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">عملکرد آزمون محور</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="chart-container">
                            <div id="container2"
                                 style="min-width: 310px; height: 400px; margin: 0 auto;direction: rtl"></div>
                        </div>
                    </div>
                </div>
                <!-- /available hours -->
            </div>
            <div class="tab-pane fade" id="comment">

                <!-- Available hours -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">کامنت ها و هدف گذاری به همراه تاریخچه</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>آیتم</th>
                                    <th> میانگین نمره(از 20)</th>
                                    <th>تعداد آزمون</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($inspections->chunk(7) as $key=>$chunk)
                                    <tr class="border-dashed">
                                        <td>{{$arzyabi[$key]}}</td>
                                        <td>{{round($chunk->avg('quality_performance_mark'),1,PHP_ROUND_HALF_UP)}}</td>
                                        <td>{{count($chunk)}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="panel-group panel-group-control panel-group-control-right content-group-lg"
                             id="accordion-control-right">
                            @foreach ($inspections as $key=>$history)
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a @if($key != 0)  class="collapsed" @endif data-toggle="collapse"
                                               data-parent="#accordion-control-right"
                                               href="#accordion-control-right-group{{$history->id}}">{{$history->exam->name}}
                                                -
                                                بازرس {{(!empty($history->bazres) ? $history->bazres->name : 'عدم تطبیق')}}
                                                - نمره {{$history->quality_performance_mark}} </a>
                                        </h6>
                                    </div>
                                    <div id="accordion-control-right-group{{$history->id}}"
                                         class="panel-collapse collapse @if($key == 0) in @endif">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>تاریخ</th>
                                                        <th> نمره</th>
                                                        <th>هدف گذاری ها</th>
                                                        <th>نقاط ضعف</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr class="border-dashed">
                                                        <td>{{$history->date}}</td>
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

                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php $mark = getMark($history->exam_id, $history->poshtiban_code) ?>
                                            @if($mark != null)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-framed">
                                                        <thead>
                                                        <tr>
                                                            <th>آیتم</th>
                                                            <th>نمره</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>نمره کارت</td>
                                                            <td>{{$mark->card}} از 2</td>
                                                        </tr>
                                                        <tr>
                                                            <td>نمره حضور</td>
                                                            <td>{{$mark->hozor_ontime}} از 1</td>
                                                        </tr>
                                                        <tr>
                                                            <td>نمره فرم بازرسی</td>
                                                            <td>{{$mark->form_bazresi}} از 1</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره تخته نویسی</td>
                                                            <td>{{$mark->takhteh_nevisi}} از 1</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره کتاب برنامه ریزی</td>
                                                            <td>{{$mark->num_barnameh}} از 3</td>
                                                        </tr>


                                                        <tr>
                                                            <td>نمره کتاب خودآموز</td>
                                                            <td>{{$mark->num_khodamoz}} از 3</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره کتاب (تابستان، زرد و ...)</td>
                                                            <td>{{$mark->num_book_tabestan}} از 3</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره کلاس رفع اشکال</td>
                                                            <td>{{$mark->rafe_eshkal}} از 2</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره برگه خودنگاری</td>
                                                            <td>{{$mark->num_khodnegari}} از 2</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره ظاهر آموزشی</td>
                                                            <td>{{$mark->quality_face}} از 2</td>
                                                        </tr>

                                                        <tr>
                                                            <td>نمره ویژه (کارهای بخصوص پشتیبان)</td>
                                                            <td>{{$mark->extera_mark}} از 2</td>
                                                        </tr>

                                                        <tr class="success">
                                                            <td>نمره نهایی</td>
                                                            <td>{{$mark->total}} از 20</td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /available hours -->
            </div>
        </div>
        <!-- /tab content -->

    </div>
    <!-- /main content -->
    <script>
        Highcharts.chart('container', {
            chart: {
                style: {
                    fontFamily: 'IRANSans-web',
                }
            },
            title: {
                text: 'عملکرد آیتم محور'
            },
            xAxis: {
                categories: [@foreach($translates as $translate) "{{$translate}}", @endforeach]
            },
            yAxis: {
                title: {
                    text: 'درصد'
                }
            },
            tooltip: {
                formatter: function () {
                    return this.series.name + ': <p>%' +
                        Highcharts.numberFormat(this.y, 0) + '</p><br/>';
                }
            },
            series: [
                {
                    type: 'column',
                    name: 'میانگین پشتیبان',
                    data: [@foreach($mean_poshtiban as $p) {{round($p,2)*100}}, @endforeach]
                }, {
                    type: 'spline',
                    name: 'میانگین حوزه',
                    data: [@foreach($mean_hozeh as $h) {{round($h,2)*100}}, @endforeach],
                    marker: {
                        lineWidth: 4,
                        lineColor: Highcharts.getOptions().colors[1],
                        fillColor: 'white'
                    },

                }, {
                    type: 'spline',
                    name: 'انحراف از معیار داده ها',
                    data: [@foreach($variances as $key=>$variance) @if(count($variance) > 0) {{round((\App\Mark::Stand_Deviation(array_values($variance))),2)*100}}, @endif @endforeach],
                    marker: {
                        lineWidth: 4,
                        lineColor: Highcharts.getOptions().colors[2],
                        fillColor: 'white'
                    },
                    dashStyle: 'shortdot',

                }]
        });
    </script>

    <script>
        Highcharts.chart('container2', {
            chart: {
                type: 'column',
                style: {
                    fontFamily: 'IRANSans-web',
                }
            },
            title: {
                text: 'عملکرد آزمون محور'
            },
            subtitle: {
                text: 'منبع: سامانه بازرسی'
            },
            xAxis: {
                categories: [
                    @foreach($exams as $exam)
                        "{{$exam->exam->name}}",
                    @endforeach
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'نمره از 20'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'نمره پشتیبان',
                data: [@foreach($mark_poshtiban as $m_p) {{$m_p}}, @endforeach]

            }, {
                name: 'میانگین حوزه',
                data: [@foreach($mark_mean_hozeh as $h_m) {{$h_m}}, @endforeach]

            },]
        });
    </script>
@stop

@php
    function getBazres($bazres_code)
    {
        $bazres = \App\Bazres::where('codemeli', 'LIKE', '%' . $bazres_code . '%')->first();
        if($bazres == null){
            return 'بدون نام';
        }
        return $bazres->name;
    }

function getExam($id)
{
    $exam = \App\Exam::find($id);
    return $exam;
}

function getMark($exam_id,$codemeli)
{
    $mark = \App\Mark::where('exam_id',$exam_id)->where('poshtiban_code',$codemeli)->first();
    return $mark;
}
@endphp
