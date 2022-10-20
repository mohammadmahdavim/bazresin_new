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
    <script type="text/javascript" src="{{url('/assets/js/pages/components_navs.js')}}"></script>
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
                            {{$modir->name}}
                        </h6>

                        <span class="display-block">مدیر حوزه</span>
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
                                آزمون محور</a></li>
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
                        <h6 class="panel-title">عملکرد آزمون محور</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right">
                           @foreach ($iars as $key=>$iar)
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a @if($key != 0)  class="collapsed" @endif data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-control-right-group{{$iar->id}}">{{$iar->exam->name}} - بازرس  {{$iar->bazres->name}} - نمره {{$iar->mark}} </a>
                                        </h6>
                                    </div>
                                    <div id="accordion-control-right-group{{$iar->id}}" class="panel-collapse collapse @if($key == 0) in @endif">
                                        <div class="panel-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td style="font-size:13px">سوالات تشریحی</td>
                                                    <td style="font-size:13px">توضیحات</td>
                                                </tr>

                                                <tr>
                                                    <td>مدیر غائب</td>
                                                    <td> {{$iar->modir_ghayeb}} </td>
                                                </tr>

                                                <tr>
                                                    <td>مدیر متأخر</td>
                                                    <td> {{$iar->modir_moteakher}} </td>
                                                </tr>

                                                <tr>
                                                    <td>پشتیبان غائب</td>
                                                    <td> {{$iar->poshtiban_ghayeb}} </td>
                                                </tr>


                                                <tr>
                                                    <td>پشتیبان متأخر</td>
                                                    <td>{{$iar->poshtiban_moteakher}}</td>
                                                </tr>


                                                <tr>
                                                    <td>اسامی پشتیبان های آموزشی</td>
                                                    <td>{{$iar->poshtiban_amozeshi}}</td>
                                                </tr>


                                                <tr>
                                                    <td>شاخص ترین نقطه قوت حوزه در این آزمون چه بود؟</td>
                                                    <td>{{$iar->shakhes_ghovat}}</td>
                                                </tr>


                                                <tr>
                                                    <td>مهم ترین عامل اختلال در نظم حوزه را چه می دانید؟</td>
                                                    <td>{{$iar->ekhtelal_nazm}}</td>
                                                </tr>


                                                <tr>
                                                    <td>به طور کلی ارزیابی شما در خصوص عملکرد اجرایی، کمی و کیفی در این حوزه چیست؟</td>
                                                    <td>{{$iar->arzyabi}}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /daily stats -->
            </div>

        </div>
        <!-- /tab content -->

    </div>
    <!-- /main content -->
@stop
