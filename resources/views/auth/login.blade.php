@extends('layouts.app')

@section('content')
    <!-- Advanced login -->
    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        <div class="panel panel-body">
            <div class="text-center">
                <img src="{{url('/assets/images/kanoon.jpg')}}" width="150px">
                <h5 class="content-group-lg"> <small class="display-block">{{ config('global.siteTitle') }}</small></h5>
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input type="text"
                       class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                       name="username" placeholder="نام کاربری" value="{{ old('username') }}" required autofocus>
                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert" style="color: red">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback has-feedback-left">
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                      placeholder="رمز عبور" name="password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group login-options">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="checkbox-inline">
                            <input type="checkbox" class="styled" checked="checked" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            بخاطر سپار
                        </label>
                    </div>

                    <div class="col-sm-6 text-right">
                        <a href="login_password_recover.html">فراموشی رمز؟</a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn bg-pink-400 btn-block">ورود</button>
            </div>

            <div class="content-divider text-muted form-group"><span>آیا حساب کاربری ندارید؟</span></div>
            <a href="/register" class="btn btn-default btn-block content-group">ثبت نام</a>
        </div>
    </form>
    <!-- /advanced login -->
@stop