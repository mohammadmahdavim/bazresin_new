<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="EcologyTheme">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سامانه بازرسان حوزه - قلم چی</title>
    <link rel="shortcut icon" href="{{url('/assets/site/images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/bootstrap.min.css')}}">
    <!-- Font awsome CSS -->
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/magnific-popup.css')}}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/owl.theme.css')}}">
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/animate.css')}}">
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/preloader.css')}}">
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/slick.css')}}">
    <!-- Mean Menu-->
    <link rel="stylesheet" href="{{url('/assets/site/css/assets/meanmenu.css')}}">

    <!-- main style-->
    <link rel="stylesheet" href="{{url('/assets/site/css/style.css')}}">
    <link rel="stylesheet" href="{{url('/assets/site/css/responsive.css')}}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>

@include('sweetalert::alert')
<header id="header" class="marketing_header">
    <div class="header-top">
        <div class="sassnex_nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light bg-faded">
                    <a class="navbar-brand" href="/"><img src="<?= url('assets/site/images/logo.png'); ?>"
                                                          alt="logo"></a>
                    <div class="collapse navbar-collapse mean_menu" id="navbarSupportedContent">
                        <ul class="navbar-nav nav ml-auto ">
                            <li class="nav-item"><a href="/" class="nav-link">خانه</a>
                            </li>
                            <li class="nav-item"><a href="#" class="nav-link">صفحات</a>
                                <ul class="dropdown_menu">
                                    <li class="nav-item"><a href="#" class="nav-link">وبلاگ</a>
                                        <ul class="dropdown_menu">
                                            <li><a href="blog.html">وبلاگ</a></li>
                                            <li><a href="blog-details.html">جزئیات وبلاگ</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a href="/contact" class="nav-link"> تماس با ما</a></li>
                                </ul>
                    </div>
                    <div class="mr-auto others_option">
                        <ul class="navbar-nav mx-auto d-flex">
                            <li class="header-search-box btn-color-dark">
                                <a href="#header-search" title="جستجو">
                                    <i class="flaticon-search search_btn"></i>
                                </a>
                            </li>
                            <li class="nav-item sign-in-option btn-demo " data-toggle="modal" data-target="#myModal2">
                                <div class="side_menu">
                                    <span class="line_1"></span>
                                    <span class="line_2"></span>
                                    <span class="line_3"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav><!-- END NAVBAR -->
            </div>
        </div>
    </div>

    <div class="intro_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">

                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="intro_banner intro_banner_marketing wow fadeInRight animated" data-wow-duration="2s"
                         data-wow-delay=".2s">
                        <img src="{{url('/assets/site/images/kanoon-logo.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner_shapes">
        <img src="{{url('/assets/site/images/shapes/m_banner_1.png')}}" alt="" class="m_banner_1">
        <img src="{{url('/assets/site/images/shapes/m_banner_2.png')}}" alt="" class="m_banner_2">
    </div>
</header> <!-- End Header -->


<!-- Search Box Start Here -->
<div id="header-search" class="header-search">
    <button type="button" class="close">×</button>
    <form class="header-search-form">
        <input type="search" value="" placeholder="در اینجا تایپ کنید........"/>
        <button type="submit" class="search-btn">جستجو</button>
    </form>
</div>


<!-- Sidebar Menu -->
<section class="sidebar_menu">
    <!-- Modal -->
    <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="flaticon-close"></i></span></button>
                    <h2 class="modal-title" id="myModalLabel2"><a href="#"><img
                                    src="{{url('/assets/site/images/logo.png')}}" alt=""></a><span
                                class="disabled">قلم چی</span></h2>
                </div>
                <div class="modal-body">
                    <div class="bar-nav">
                        <div class="bar-top">
                            <h2>صفحات</h2>
                            <ul>
                                <li><a href="/">خانه</a></li>
                                <li><a href="/blog">وبلاگ</a></li>
                                <li><a href="/about">درباره ما</a></li>
                                <li><a href="/contact">تماس با ما</a></li>
                                @if(Auth::guest())
                                <li><a href="/login">ورود </a></li>
                                @else
                                    <li><a href="/logout">خروج </a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="bar-contact">
                        <span>تماس</span>
                        <span>+021 900077</span>
                    </div>

                    <div class="bar-icon">
                        <div class="serach_option widget_single">
                            <form>
                                <input type="text" name="Name" class="input-c" placeholder="نام">
                                <button type="submit"><i class="flaticon-paper-plane"></i></button>
                            </form>
                        </div>
                        <ul class="social_iocns d-flex ">
                            <li><a href="#"><i class="flaticon-facebook-logo icon_tw"></i></a></li>
                            <li><a href="#"><i class="flaticon-twitter icon_fb"></i></a></li>
                            <li><a href="#"><i class="flaticon-instagram-logo icon_pin"></i></a></li>
                            <li><a href="#"><i class="flaticon-linkedin-logo icon_link"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div><!-- modal-content -->
        </div><!-- modal-dialog -->
    </div><!-- modal -->
</section><!-- sidebar -->


<!-- star Need Help -->
<section class="need_help">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="subscribe_wrapper justify-content-between d-flex ">
                    <div class="subscribe_title">
                        <h2>به سامانه بازرسان حوزه های تهران قلم چی خوش آمدید</h2>
                    </div>
                    <a href="#" class="chat_btn g-btn">شروع کنید</a>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Need Help -->


<!-- Marketing Footer Area -->
<footer class="footer marketing_footer">
    <div class="container">
        <div class="footer_top footer_top_u">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="footer-title">
                        <img src="images/logo.png" alt="" class="f_logo">
                        <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                            چاپگرها و متون بلکه روزنامه و مجله.</p>
                        <ul class="social_iocns d-flex">
                            <li><a href="#" class="active"><i class="flaticon-facebook-logo icon_tw"></i></a></li>
                            <li><a href="#"><i class="flaticon-twitter icon_fb"></i></a></li>
                            <li><a href="#"><i class="flaticon-instagram-logo icon_pin"></i></a></li>
                            <li><a href="#"><i class="flaticon-linkedin-logo icon_link"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="company-content">
                        <h3>اطلاعات تماس</h3>
                        <ul class="location_info">
                            <li><i class="flaticon-placeholder"></i>کانون فرهنگی آموزشی قلم چی</li>
                            <li><i class="flaticon-push-pin"></i>تهران, ایران</li>
                            <li><i class="flaticon-envelope"></i>info@bazresin.ir</li>
                            <li><i class="flaticon-phone-call"></i>+00 985 260</li>
                            <li><i class="flaticon-global"></i><a href="#" title="">www.bazresin.ir</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="company-content about_footer">
                        <h3>درباره ما</h3>
                        <ul>
                            <li><a href="#">رهبری</a></li>
                            <li><a href="#">شرکت</a></li>
                            <li><a href="#">تنوع</a></li>
                            <li><a href="#">مشاغل</a></li>
                            <li><a href="#">مطبوعات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-2">
                    <div class="company-content">
                        <h3>راهکارهای تیم</h3>
                        <ul>
                            <li><a href="#">تامین مالی</a></li>
                            <li><a href="#">شرکت کنید</a></li>
                            <li><a href="#">فروشگاه</a></li>
                            <li><a href="#">اسم فرضی</a></li>
                            <li><a href="#">اسم فرضی</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>کپی رایت &copy; محمد فخرانی 1397. همه حقوق محفوظ است.</p>
                </div>
                <div class="col-md-6">
                    <ul class="copy_right_items d-flex justify-content-end">
                        <li><a href="#">شرایط و استفاده</a></li>
                        <li><a href="#">حریم خصوصی</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer><!-- End Footer -->

<section id="scroll-top" class="scroll-top">
    <h2 class="disabled">به بالای صفحه بروید</h2>
    <div class="to-top pos-rtive">
        <a href="#"><i class="flaticon-right-arrow"></i></a>
    </div>
</section>

<!-- JavaScript -->
<script src="{{url('assets/site/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{url('/assets/site/js/popper.min.js')}}"></script>
<script src="{{url('/assets/site/js/bootstrap.min.js')}}"></script>
<script src="{{url('/assets/site/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{url('/assets/site/js/owl.carousel.min.js')}}"></script>
<script src="{{url('/assets/site/js/slick.min.js')}}"></script>
<!-- Main Menu -->
<script src="{{url('/assets/site/js/jquery.meanmenu.min.js')}}"></script>
<script src="{{url('/assets/site/js/wow.min.js')}}"></script>
<script src="{{url('/assets/site/js/custom.js')}}"></script>

<!-- Extera Script -->
@yield('script')

</body>

</html>
