@extends('layouts.UserLayouts')


@section('script')
    <meta name="_token" content="{{csrf_token()}}">
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_layouts.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/datatables_basic.js')}}"></script>

    <script>
        poshtiban_report = function (codemeli,exam_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
               url : '{{url('/user/report/poshtiban')}}',
               type: 'POST',
               data: {'exam_id' : exam_id,'codemeli' : codemeli} ,
                success : function (response) {
                    $('#modal_full').modal('show');
                    $('#modal_full').html(response);
                }
            });
        }
    </script>
@stop


@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"> لیست پشتیبان های مدیر </h5>
            <div class="heading-elements">
                <a class="btn btn-success" onclick="export_excel('');"> اکسل  پشتیبانی<i class="icon-file-excel"></i></a>
                <a class="btn btn-success" onclick="export_performance_pdf('');">عملکرد آزمون محور<i class="icon-file-excel"></i></a>
            </div>
        </div>

        <div class="panel-body">

            <table class="table datatable-basic table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>نام مدیر پشتیبان</th>
                    <th> نام پشتیبان</th>
                    <th>وضعیت آزمون</th>
                    <th> نمره ارزیابی</th>
                    <th> جزئیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($modirs as $modir)
                    <tr>
                        <td>{{$modir->modir_poshtiban}}</td>
                        <td>{{$modir->poshtiban}}</td>
                        <td>
                            @switch($modir->status)
                                @case(1)
                                حاضر
                                @break
                                @case(2)
                                بازدید مجدد
                                @break
                                @case(3)
                                غائب
                                @break
                                @case(4)
                                قطع همکاری
                                @break
                                @default
                                عدم بازرسی
                            @endswitch
                        </td>
                        <td>{{\App\Mark::where('exam_id',$exam_id)->where('poshtiban_code',$modir->poshtiban_code)->first()['total']}}</td>
                        <td>
                            <a type="button" class="btn btn-info btn-sm" href="{{url('/user/report/poshtiban/'.$exam_id.'/'.$modir->poshtiban_code)}}" > عملکرد فعلی <i class="icon-play3 position-right"></i>
                            </a>
                            <a class="btn btn-success"> عملکرد کلی </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>


    <!-- Full width modal -->
    <div id="modal_full" class="modal fade">
        @include('user.include.modal')
    </div>
    <!-- /full width modal -->

@stop
