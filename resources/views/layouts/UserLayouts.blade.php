<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پنل کاربری - {{ config('global.siteTitle') }}</title>

    <!-- Global stylesheets -->
    <link href="{{url('/assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/assets/css/colors.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="<?= url('/assets/calender/persian-event-calendar.js'); ?>">
    <link rel="stylesheet" href="<?= url('/assets/calender/assets/css/style.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= url('/assets/calender/style/kamadatepicker.css'); ?>"/>
    <!-- Css Extera page -->
@yield('css')
<!-- /Css Extera page -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{url('/assets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/nicescroll.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/drilldown.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/fab.min.js')}}"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="<?= url('/assets/calender/persian-event-calendar.js'); ?>"></script>
    <script src="<?= url('/assets/calender/assets/js/init.js'); ?>" type="text/javascript"></script>
    <script src="<?= url('/assets/calender/src/kamadatepicker.js'); ?>"></script>
    <!-- Theme JS files -->
    <script type="text/javascript" src="{{url('/assets/js/core/app.js')}}"></script>
    <!-- /theme JS files -->

    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript,
        if it's not present, don't show loader */
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(/assets/loader/images/loader-64x/Preloader_3.gif) center no-repeat #fff;
        }

    </style>
    <script>
        //paste this code under head tag or in a seperate js file.
        // Wait for window load
        $(window).load(function () {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
            ;
        });
    </script>
    <!-- Js Extera for Page -->
@yield('script')
<!-- /Js Extera for Page -->


</head>

<body class="navbar-bottom">
<div class="se-pre-con"></div>
<!-- Page header -->
<div class="page-header page-header-inverse bg-indigo">
@include('sweetalert::alert')
<!-- Main navbar -->
    <div class="navbar navbar-inverse navbar-transparent">
        <div class="navbar-header">
            <a class="navbar-brand" href="/user"><img src="{{url('assets/images/logo_light.png')}}" alt=""></a>
            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-grid3"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <p class="navbar-text"><span class="label bg-success-400">نسخه آزمایشی</span></p>

            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{url('/assets/images/user_image/'.Auth::user()->avatar)}}" alt="">
                            <span>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="/user/profile"><i class="icon-user-check"></i>پروفایل</a></li>
                            {{--                            <li><a href="#"><i class="icon-history"></i> سابقه بازرسی </a></li>--}}
                            {{--                            <li><a href="#"><span class="badge bg-blue pull-right">26</span> <i--}}
                            {{--                                        class="icon-comment-discussion"></i> پیام ها</a></li>--}}
                            <li class="divider"></li>
                            <li><a href="/logout"><i class="icon-switch2"></i> خروج</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page header content -->
    <div class="page-header-content">
        <div class="page-title">
            <h4> {{$navbar['name']}}
                <small>{{$navbar['description']}}</small>
            </h4>
        </div>

        <div class="heading-elements">
            <ul class="breadcrumb heading-text">
                <li><a href="/user"><i class="icon-home2 position-left"></i> خانه</a></li>
                <li class="active">{{$navbar['name']}}</li>
            </ul>
        </div>
    </div>
    <!-- /page header content -->


    <!-- Second navbar -->
    <div class="navbar navbar-inverse navbar-transparent" id="navbar-second">
        <ul class="nav navbar-nav visible-xs-block">
            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i
                        class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-second-toggle">
            <ul class="nav navbar-nav navbar-nav-material">
                <li><a href="/user">داشبورد</a></li>
                @can('bazresi')
                    <li><a href="/user/azmoon">آزمون ها</a></li>
                @endcan

                @can('presence-statistics')
                    <li><a href="/user/inspector">بازرس سایت</a></li>
                @endcan

                @can('report-bazresi')
                    <li class="dropdown mega-menu mega-menu-wide">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> سربازرس <span class="caret"></span></a>

                        <div class="dropdown-menu dropdown-content">
                            <div class="dropdown-content-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="menu-heading underlined"> آمار کلی </span>
                                        <ul class="menu-list">
                                            <li>
                                                <a href="{{url('/user/report/modir')}}"><i class="icon-book2"></i>عملکرد
                                                    آزمون محور</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="menu-heading underlined">آزمون</span>
                                        <ul class="menu-list">
                                            <li>
                                                <a href="{{url('/user/leader/dataEntry')}}"><i class="icon-pencil6"></i>مدیریت
                                                    اطلاعات</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="menu-heading underlined">کاربر محور</span>
                                        <ul class="menu-list">
                                            <li>
                                                <a href="/user/leader/modirs"><i class="icon-user-tie"></i>مدیران</a>
                                            </li>
                                            <li>
                                                <a href="/user/leader/poshtibans"><i
                                                        class="icon-users4"></i>پشتیبانان</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endcan
            </ul>

        </div>
    </div>
    <!-- /second navbar -->


    <!-- Floating menu -->
    <ul class="fab-menu fab-menu-top-right" data-fab-toggle="click">
        <li>
            <a class="fab-menu-btn btn bg-pink-300 btn-float btn-rounded btn-icon">
                <i class="fab-icon-open icon-plus3"></i>
                <i class="fab-icon-close icon-cross2"></i>
            </a>

            <ul class="fab-menu-inner">
                <li>
                    <div data-fab-label="آزمون ها">
                        <a href="/user/azmoon" class="btn btn-default btn-rounded btn-icon btn-float">
                            <i class="icon-pencil"></i>
                        </a>
                    </div>
                </li>
                {{--                <li>--}}
                {{--                    <div data-fab-label="پیام ها">--}}
                {{--                        <a href="#" class="btn btn-default btn-rounded btn-icon btn-float">--}}
                {{--                            <i class="icon-bubbles7"></i>--}}
                {{--                        </a>--}}
                {{--                        <span class="badge bg-primary-400">5</span>--}}
                {{--                    </div>--}}
                {{--                </li>--}}
            </ul>
        </li>
    </ul>
    <!-- /floating menu -->

</div>
<!-- /page header -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        @yield('content')

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->


<!-- Footer -->
<div class="navbar navbar-default navbar-fixed-bottom footer">
    <ul class="nav navbar-nav visible-xs-block">
        <li><a class="text-center collapsed" data-toggle="collapse" data-target="#footer"><i
                    class="icon-circle-up2"></i></a></li>
    </ul>

    <div class="navbar-collapse collapse" id="footer">
        <div class="navbar-text">
            &copy; ۱۳۹۷. سامانه بازرسین حوزه کانون قلم چی
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="#">راهنما</a></li>
                <li><a href="#">تماس با ما</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- /footer -->
<script>
    kamaDatepicker('date1', {buttonsColor: "red"});

    var customOptions = {
        placeholder: "روز / ماه / سال"
        , twodigit: false
        , closeAfterSelect: false
        , nextButtonIcon: "fa fa-arrow-circle-right"
        , previousButtonIcon: "fa fa-arrow-circle-left"
        , buttonsColor: "blue"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
        , gotoToday: true
    }
    kamaDatepicker('date2', customOptions);

    kamaDatepicker('date3', {
        nextButtonIcon: "timeir_next.png"
        , previousButtonIcon: "timeir_prev.png"
        , forceFarsiDigits: true
        , markToday: true
        , markHolidays: true
        , highlightSelectedDay: true
        , sync: true
    });

    // for testing sync functionallity
    $("#date2").val("1311/10/01");
</script>
</body>
</html>
