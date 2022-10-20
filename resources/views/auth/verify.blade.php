@extends('layouts.app')

@section('content')
    <!-- Password recovery -->
    <form action="{{url('/verify')}}" method="post" class="login-form">
        @csrf
        <div class="panel panel-body">
            <div class="text-center">
                <div class="icon-object border-warning text-warning"><i class="icon-mobile2"></i></div>
                <h5 class="content-group"> تایید تلفن همراه </h5>
            </div>

            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="کد را وارد نمایید" name="code">
                <div class="form-control-feedback">
                    <i class="icon-mobile text-muted"></i>
                </div>
            </div>

            <button type="submit" class="btn bg-teal-400 btn-block">تایید<i class="icon-arrow-left13 position-right"></i></button>
        </div>
    </form>
    <!-- /password recovery -->
@endsection
