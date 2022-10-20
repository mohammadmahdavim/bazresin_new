@extends('layouts.UserLayouts')


@section('content')
    <!-- Simple statistics -->
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <a href="{{url('/user/azmoon')}}">
                <div class="panel panel-body bg-green-400 has-bg-image">
                    <div class="media no-margin">
                        <div class="media-body">
                            <h3 class="no-margin">{{getExam()}}</h3>
                            <span class="text-uppercase text-size-mini">آزمون های فعال</span>
                        </div>

                        <div class="media-right media-middle">
                            <i class="icon-check2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-md-4">
            <div class="panel panel-body bg-danger-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin">0</h3>
                        <span class="text-uppercase text-size-mini">تاریخچه بازرسی</span>
                    </div>

                    <div class="media-right media-middle">
                        <i class="icon-history icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-md-4">
            <div class="panel panel-body bg-info-400 has-bg-image">
                <div class="media no-margin">
                    <div class="media-body">
                        <h3 class="no-margin">0</h3>
                        <span class="text-uppercase text-size-mini">پیام ها</span>
                    </div>

                    <div class="media-right media-middle">
                        <i class="icon-bubbles4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /simple statistics -->

@stop

@php
    function getExam(){
        return \App\Exam::where('status', 1)->count();
    }
@endphp
