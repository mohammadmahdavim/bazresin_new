@extends('layouts.app')

@section('script')

@stop

@section('content')
    <!-- Registration form -->
    <form method="POST" action="{{ route('register') }}" class="registration-form">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="panel">
                    <div class="panel-body">
                        <div class="text-center">
                            <img src="{{url('/assets/images/kanoon.jpg')}}" width="150px">
                            <h5 class="content-group-lg"> ثبت نام
                                <small class="display-block">{{ config('global.siteTitle') }}</small>
                            </h5>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="username" placeholder="کدملی">
                            <div class="form-control-feedback">
                                <i class="icon-user-plus text-muted"></i>
                            </div>
                            @if ($errors->has('username'))
                                <span class="invalid-feedback" role="alert" style="color: red">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="first_name" placeholder="نام">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-check text-muted"></i>
                                    </div>

                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="last_name" placeholder="نام خانوادگی">
                                    <div class="form-control-feedback">
                                        <i class="icon-user-check text-muted"></i>
                                    </div>
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <input id="password" type="password" placeholder="رمز عبور"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <input id="password-confirm" type="password" placeholder="تکرار رمز عبور"
                                           class="form-control" name="password_confirmation" required>
                                    <div class="form-control-feedback">
                                        <i class="icon-user-lock text-muted"></i>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <input type="text" class="form-control" name="mobile" placeholder="موبایل">
                                    <div class="form-control-feedback">
                                        <i class="icon-mobile2 text-muted"></i>
                                    </div>
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <select class="form-control" name="sex">
                                        <option value="">جنسیت</option>
                                        <option value="man">آقا</option>
                                        <option value="woman">خانم</option>
                                    </select>
                                    <div class="form-control-feedback">
                                        <i class="icon-user-tie text-muted"></i>
                                    </div>
                                    @if ($errors->has('sex'))
                                        <span class="invalid-feedback" role="alert" style="color: red">
                                                <strong>{{ $errors->first('sex') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                            <a href="/login" class="btn btn-default pull-left"><i
                                        class="icon-arrow-left13 position-left"></i> صفحه ورود
                            </a>
                            <button type="submit"
                                    class="btn bg-pink-400 btn-labeled btn-labeled-right pull-right btn-submit"><b>
                                    <i class="icon-enter5"></i></b> ثبت نام
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /registration form -->
@stop

