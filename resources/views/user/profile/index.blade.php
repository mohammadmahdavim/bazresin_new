@extends('layouts.UserLayouts')

@section('css')

@endsection





@section('script')
    <script type="text/javascript" src="/assets/js/core/libraries/jasny_bootstrap.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script>
        $(function () {

            // Default file input style
            $(".file-styled").uniform({
                fileButtonClass: 'action btn btn-warning'
            });


            // Primary file input
            $(".file-styled-primary").uniform({
                fileButtonClass: 'action btn bg-blue'
            });

            $(".styled, .multiselect-container input").uniform({
                radioClass: 'choice'
            });

            // File input
            $(".file-styled").uniform({
                wrapperClass: 'bg-blue',
                fileButtonHtml: '<i class="icon-file-plus"></i>'
            });


        });
    </script>
    <script type="text/javascript" src="/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/pages/user_profile_tabbed.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/ui/ripple.min.js"></script>

    <script>
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("pass2fa");
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>

@endsection


@section('content')
    <!-- Main sidebar -->
    <div class="sidebar sidebar-main sidebar-default sidebar-separate">
        <div class="sidebar-content">

            <!-- User details -->
            <div class="content-group">
                <div class="panel-body bg-indigo-400 border-radius-top text-center"
                     style="background-size: contain;">
                    <div class="content-group-sm">
                        <h6 class="text-semibold no-margin-bottom">
                            {{auth()->user()->first_name.' '.auth()->user()->last_name}}
                        </h6>
                        <span class="display-block">
                            @if(auth()->user()->role == 'bazres')
                                بازرس
                            @elseif(auth()->user()->role == 'admin')
                                مدیر
                            @endif
                        </span>
                    </div>

                    <a href="#" class="display-inline-block content-group-sm">
                        <img src="{{url('/assets/images/user_image/'.Auth::user()->avatar)}}"
                             class="img-circle img-responsive" alt="" style="width: 110px; height: 110px;">
                    </a>
                </div>

                <div class="panel no-border-top no-border-radius-top">
                    <ul class="navigation">
                        <li class="navigation-header">صفحات</li>
                        <li class="active"><a href="#profile" data-toggle="tab"><i class="icon-files-empty"></i>پروفایل</a>
                        </li>
                        <li><a href="#messages" data-toggle="tab"><i class="icon-files-empty"></i> پیام ها </a></li>
                        <li><a href="#history" data-toggle="tab"><i class="icon-files-empty"></i> تاریخچه</a></li>
                        <li class="navigation-divider"></li>
                        <li><a href="login_advanced.html"><i class="icon-switch2"></i>خروج</a></li>
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

                <!-- Profile info -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title"> اطلاعات کاربری </h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        {!! Form::model( $user , [ 'method'=>'PUT' , 'action'=>['User\ProfileController@update'],'files'=>true ] ) !!}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>کدملی</label>
                                    {{ Form::text('username',null,['class'=>'form-control','readonly'=>'readonly']) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>نام</label>
                                    {{ Form::text('first_name',null,['class'=>'form-control']) }}
                                </div>
                                <div class="col-md-6">
                                    <label>نام خانوادگی</label>
                                    {{ Form::text('last_name',null,['class'=>'form-control']) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>موبایل</label>
                                    {{ Form::text('mobile',null,['class'=>'form-control','readonly'=>'readonly']) }}
                                </div>

                                <div class="col-md-6">
                                    <label class="display-block">عکس کاربری</label>
                                    <input type="file" class="file-styled" name="avatar">
                                    <span
                                        class="help-block"> فرمت قابل قبول : jpg</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">بروزرسانی <i
                                    class="icon-arrow-left13 position-right"></i></button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /profile info -->


                <!-- Account settings -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">تغییر رمز حساب</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="reload"></a></li>
                                <li><a data-action="close"></a></li>
                            </ul>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" id="alert_show">
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        </div>
                    @endif


                    <div class="panel-body">
                        <form action="{{url('/user/profile/setting')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>نام کاربری</label>
                                        <input type="text" value="{{auth()->user()->username}}" readonly="readonly"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>رمز فعلی</label>
                                        <input type="password" name="password_current"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>رمز جدید</label>
                                        <input type="password" name="password" placeholder="حداقل 6 کاراکتر"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>تکرار رمز جدید</label>
                                        <input type="password" name="password_confirmation"
                                               placeholder="حداقل 6 کاراکتر" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>نحوه ورود به پنل</label>

                                        <div class="radio">
                                            <label>
                                                <input type="checkbox" id="myCheck" onclick="myFunction()"
                                                       class="styled" @if(auth()->user()->token_2fa != null) checked="checked" @endif>
                                                دو مرحله ای با امنیت بالا
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" style="display: none;" id="pass2fa">
                                        <label>رمز دو مرحله ای</label>
                                        <input type="password" name="password2fa" value="{{auth()->user()->token_2fa}}"
                                               placeholder="حداقل 4 کاراکتر" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">ثبت <i
                                        class="icon-arrow-left13 position-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /account settings -->

            </div>

            <div class="tab-pane fade" id="messages">

                <!-- My inbox -->
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h6 class="panel-title">صندوق پیام ها</h6>
                    </div>

                    <div class="table-responsive">

                    </div>
                </div>
                <!-- /my inbox -->

            </div>

            <div class="tab-pane fade" id="history">

                <!-- Orders history -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h6 class="panel-title">تاریخچه بازرسی</h6>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">تاریخ</th>
                                <th>زمان شروع بازرسی</th>
                                <th>زمان پایان بازرسی</th>
                                <th>جمع کل</th>
                                <th>حوزه </th>
                                <th>آدرس </th>
                                <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="active border-double">
                                <td colspan="7" class="text-semibold text-center" >در دست طراحی</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /orders history -->

            </div>
        </div>
        <!-- /tab content -->

    </div>
    <!-- /main content -->

@endsection

