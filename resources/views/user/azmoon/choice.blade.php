@extends('layouts.UserLayouts')

@section('content')
    <!-- Simple statistics -->
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <a href="{{url('/user/azmoon/'.$azmoon->id)}}">
            <div class="panel panel-body panel-body-accent">
                <div class="media no-margin">
                    <div class="media-left media-middle">
                        <i class="icon-users4 icon-3x text-success-400"></i>
                    </div>

                    <div class="media-body text-right">
                        <h3 class="no-margin text-semibold">پشتیبان ها</h3>
                        <span class="text-uppercase text-size-mini text-muted">لیست پشتیبان ها</span>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <div class="col-sm-4 col-md-4">
            <a href="{{url('/user/azmoon/modir/'.$azmoon->id)}}">
                <div class="panel panel-body">
                    <div class="media no-margin">
                        <div class="media-left media-middle">
                            <i class="icon-users2 icon-3x text-indigo-400"></i>
                        </div>

                        <div class="media-body text-right">
                            <h3 class="no-margin text-semibold">مدیران</h3>
                            <span class="text-uppercase text-size-mini text-muted">لیست مدیر حوزه</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-sm-4 col-md-4">
            <a href="{{url('/user/azmoon/bazres/'.$azmoon->id)}}">
                <div class="panel panel-body panel-body-accent">
                    <div class="media no-margin">
                        <div class="media-left media-middle">
                            <i class="icon-play3 icon-3x text-warning-400"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="no-margin text-semibold">لاگ بازرسی</h3>
                            <span class="text-uppercase text-size-mini text-muted">بازرس در ابتدا و انتهای آزمون ثبت نماید</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <!-- /simple statistics -->
@stop
