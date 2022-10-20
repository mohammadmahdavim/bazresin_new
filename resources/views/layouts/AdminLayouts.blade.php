<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پنل کاربری - سامانه بازرسین قلم چی</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Global stylesheets -->
    <link href="{{url('/assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
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
@include('sweetalert::alert')


<!-- Page header -->
<div class="page-header page-header-inverse bg-indigo">

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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-bell2"></i>
                            <span class="visible-xs-inline-block position-right">Activity</span>
                            <span class="status-mark border-pink-300"></span>
                        </a>

                        <div class="dropdown-menu dropdown-content">
                            <div class="dropdown-content-heading">
                                Activity
                                <ul class="icons-list">
                                    <li><a href="#"><i class="icon-menu7"></i></a></li>
                                </ul>
                            </div>

                            <ul class="media-list dropdown-content-body width-350">
                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i class="icon-mention"></i></a>
                                    </div>

                                    <div class="media-body">
                                        <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks"
                                        <div class="media-annotation">4 minutes ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-xs"><i class="icon-paperplane"></i></a>
                                    </div>

                                    <div class="media-body">
                                        Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a>
                                        <div class="media-annotation">36 minutes ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-blue btn-rounded btn-icon btn-xs"><i class="icon-plus3"></i></a>
                                    </div>

                                    <div class="media-body">
                                        <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch in <span class="text-semibold">Limitless</span> repository
                                        <div class="media-annotation">2 hours ago</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-purple-300 btn-rounded btn-icon btn-xs"><i class="icon-truck"></i></a>
                                    </div>

                                    <div class="media-body">
                                        Shipping cost to the Netherlands has been reduced, database updated
                                        <div class="media-annotation">Feb 8, 11:30</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-warning-400 btn-rounded btn-icon btn-xs"><i class="icon-bubble8"></i></a>
                                    </div>

                                    <div class="media-body">
                                        New review received on <a href="#">Server side integration</a> services
                                        <div class="media-annotation">Feb 2, 10:20</div>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs"><i class="icon-spinner11"></i></a>
                                    </div>

                                    <div class="media-body">
                                        <strong>January, 2016</strong> - 1320 new users, 3284 orders, $49,390 revenue
                                        <div class="media-annotation">Feb 1, 05:46</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-bubble8"></i>
                            <span class="visible-xs-inline-block position-right">Messages</span>
                        </a>

                        <div class="dropdown-menu dropdown-content width-350">
                            <div class="dropdown-content-heading">
                                Messages
                                <ul class="icons-list">
                                    <li><a href="#"><i class="icon-menu7"></i></a></li>
                                </ul>
                            </div>

                            <ul class="media-list dropdown-content-body">
                                <li class="media">
                                    <div class="media-left">
                                        <img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                        <span class="badge bg-danger-400 media-badge">5</span>
                                    </div>

                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">James Alexander</span>
                                            <span class="media-annotation pull-right">04:58</span>
                                        </a>

                                        <span class="text-muted">who knows, maybe that would be the best thing for me...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left">
                                        <img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt="">
                                        <span class="badge bg-danger-400 media-badge">4</span>
                                    </div>

                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Margo Baker</span>
                                            <span class="media-annotation pull-right">12:16</span>
                                        </a>

                                        <span class="text-muted">That was something he was unable to do because...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Jeremy Victorino</span>
                                            <span class="media-annotation pull-right">22:48</span>
                                        </a>

                                        <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Beatrix Diaz</span>
                                            <span class="media-annotation pull-right">Tue</span>
                                        </a>

                                        <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                    </div>
                                </li>

                                <li class="media">
                                    <div class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></div>
                                    <div class="media-body">
                                        <a href="#" class="media-heading">
                                            <span class="text-semibold">Richard Vango</span>
                                            <span class="media-annotation pull-right">Mon</span>
                                        </a>

                                        <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{url('/assets/images/user_image/'.Auth::user()->avatar)}}" alt="">
                            <span>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="icon-user-plus"></i>پروفایل</a></li>
                            <li><a href="/user"><i class="icon-user"></i>پنل کاربری</a></li>
                            <li><a href="#"><span class="badge bg-blue pull-right">26</span> <i class="icon-comment-discussion"></i> پیام ها</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="icon-cog5"></i>تنظیمات حساب</a></li>
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
            <h4> {{$navbar['name']}} <small>{{$navbar['description']}}</small></h4>
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
            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-second-toggle">
            <ul class="nav navbar-nav navbar-nav-material">
                <li><a href="/admin">داشبورد</a></li>

                <li class="dropdown mega-menu mega-menu-wide">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">بازرسی <span class="caret"></span></a>

                    <div class="dropdown-menu dropdown-content">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="menu-heading underlined">سایت</span>
                                    <ul class="menu-list">
                                        <li>
                                            <a href="#"><i class="icon-grid"></i> کاربران</a>
                                            <ul>
                                                <li><a href="/admin/users">مدیریت کاربران</a></li>
                                                <li><a href="/admin/inspector">مدیریت بازرسان</a></li>
                                                <li><a href="/admin/modir">مدیریت مدیران</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <span class="menu-heading underlined">حوزه ها</span>
                                    <ul class="menu-list">
                                        <li>
                                            <a href="/admin/hozeh"><i class="icon-library2"></i> مدیریت حوزه ها</a>
                                        </li>

                                        <li>
                                            <a href="/admin/hozeh/layouts"><i class="icon-magic-wand"></i>چیدمان حوزه ها</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <span class="menu-heading underlined">آزمون ها</span>
                                    <ul class="menu-list">
                                        <li>
                                            <a href="/admin/exams/create"><i class="icon-upload"></i>ایجاد آزمون</a>
                                        </li>
                                        <li>
                                            <a href="/admin/exams"><i class="icon-calendar3"></i> مدیریت آزمون</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon-list3"></i>فرم IAR</a>
                                            <ul>
                                                <li><a href="/admin/iar/question">مدیریت سوالات</a></li>
                                                <li><a href="fullcalendar_formats.html">فرم های ثبت شده</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="dropdown mega-menu mega-menu-wide">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">گزارش ها <span class="caret"></span></a>

                    <div class="dropdown-menu dropdown-content">
                        <div class="dropdown-content-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="menu-heading underlined">حوزه محور</span>
                                    <ul class="menu-list">

                                        <li>
                                            <a href="#"><i class="icon-droplet2"></i>عملکرد</a>
                                            <ul>
                                                <li><a href="colors_primary.html">وضعیت حوزه</a></li>
                                                <li class="divider"></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <span class="menu-heading underlined">پشتیبان محور</span>
                                    <ul class="menu-list">
                                        <li>
                                            <a href="#"><i class="icon-graph"></i> وضعیت پشتیبان ها</a>
                                            <ul>
                                                <li><a href="echarts_lines_areas.html">رنگ عملکرد </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <span class="menu-heading underlined">بازرس محور</span>
                                    <ul class="menu-list">
                                        <li>
                                            <a href="#"><i class="icon-graph"></i> وضعیت بازرسان</a>
                                            <ul>
                                                <li><a href="echarts_lines_areas.html">تاریخچه بازرسی</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-nav-material navbar-right">
                <li>
                    <a href="changelog.html">
                        <span class="status-mark status-mark-inline border-success-300 position-left"></span>
                        بروزرسانی ها
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-cog3"></i>
                        <span class="visible-xs-inline-block position-right">Settings</span>
                        <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="/admin/permissions"><i class="icon-key"></i> مجوز ها</a></li>
                        <li><a href="/admin/roles"><i class="icon-accessibility"></i> دسترسی ها</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="icon-gear"></i> همه تنظیمات</a></li>
                    </ul>
                </li>
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
                    <div data-fab-label="Compose email">
                        <a href="#" class="btn btn-default btn-rounded btn-icon btn-float">
                            <i class="icon-pencil"></i>
                        </a>
                    </div>
                </li>
                <li>
                    <div data-fab-label="Conversations">
                        <a href="#" class="btn btn-default btn-rounded btn-icon btn-float">
                            <i class="icon-bubbles7"></i>
                        </a>
                        <span class="badge bg-primary-400">5</span>
                    </div>
                </li>
                <li>
                    <div data-fab-label="Chat with Jack">
                        <a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-float">
                            <img src="assets/images/placeholder.jpg" class="img-responsive" alt="">
                        </a>
                        <span class="status-mark border-pink-400"></span>
                    </div>
                </li>
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
        <li><a class="text-center collapsed" data-toggle="collapse" data-target="#footer"><i class="icon-circle-up2"></i></a></li>
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
