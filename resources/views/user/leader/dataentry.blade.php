@extends('layouts.UserLayouts')


@section('script')
    <script type="text/javascript" src="{{url('/assets/js/core/libraries/jquery_ui/interactions.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script type="text/javascript" src="{{url('/assets/js/pages/form_select2.js')}}"></script>

    <!-- /theme JS files -->
@stop


@section('content')
    <div class="row">
        <!-- Single button -->
        @foreach( $exams as $exam )
            <div class="col-md-6">
                <div class="panel border-left-lg border-left-info invoice-grid timeline-content">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="text-semibold no-margin-top">{{$exam->name}}</h6>
                                <ul class="list list-unstyled">
                                    <li>شماره تماس آپلود کننده : {{$exam->supervisor}}</li>
                                </ul>
                            </div>

                            <div class="col-sm-6">
                                <h6 class="text-semibold text-right no-margin-top"></h6>
                                <ul class="list list-unstyled text-right">

                                    <li>
                                        <button type="button" data-toggle="modal"
                                                data-target="#modal_theme_info{{ $exam->id }}"
                                                class="btn btn-primary heading-btn pull-right">ورود
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer panel-footer-condensed">
                        <div class="heading-elements">
							<span class="heading-text">
                                <span class="status-mark border-danger position-left"></span> تاریخ برگزاری آزمون: <span
                                    class="text-semibold">{{$exam->date}}</span>
							</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $exams->render("pagination::site") }}

    @foreach( $exams as $exam )
        <!-- Info modal -->
        <div id="modal_theme_info{{ $exam->id }}" class="modal fade">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">{{ $exam->name }}</h6>
                        </div>

                        <div class="modal-body">
                            <h6 class="text-semibold">توضیحات : </h6>
                            {!! $exam->description !!}
                        </div>

                        <div class="modal-footer">
                            <div class="input-group">
                                <a href="{{url('user/leader/dataEntry/'.$exam->id)}}" class="btn btn-info">ورود اطلاعات</a>
                                <a href="{{url('user/leader/dataEntry/excel/'.$exam->id)}}" class="btn btn-success"><i class="icon-file-excel"></i>اکسل پشتیبانان</a>
                                <a href="{{url('user/leader/dataEntry/pdf/'.$exam->id)}}" class="btn btn-danger"><i class="icon-file-pdf"></i>فایل PDF فرم IAR</a>
                            </div>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
            </div>
        </div>
        <!-- /info modal -->
    @endforeach
@stop
