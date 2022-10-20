@extends('layouts.UserLayouts')

@section('script')

    <script type="text/javascript"
            src="<?= url('assets/js/plugins/forms/selects/bootstrap_select.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= url('assets/js/pages/form_bootstrap_select.js'); ?>"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/inputs/touchspin.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_input_groups.js')}}"></script>

    <script type="text/javascript" src="{{url('/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/datatables_basic.js')}}"></script>

    <script>
        save_poshtiban = function () {
            Swal.fire({
                title: 'صبر کنید ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
            var data = $("#form_poshtiban").serializeArray();
            $.ajax({
                url: '{{ url('/user/azmoon/poshtiban/create') }}',
                type: 'POST',
                data: data,

                success: function (data) {
                    if (!data.errors) {
                        swal.close();
                        $("#alert_show").hide();
                        Swal.fire({
                            type: 'success',
                            title: 'با موفقیت ایجاد گردید گردید',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.replace("/" + data.messages.row_id);
                    } else {
                        $("#alert_show").html('');
                        jQuery.each(data.errors, function (key, value) {
                            jQuery('.alert-danger').show();
                            jQuery('.alert-danger').append('<p>' + value + '</p>');
                        });
                        swal.close();
                    }

                },
            });
        };
    </script>

    <meta name="_token" content="{{csrf_token()}}">

    <script>
        getMark = function (exam_id,codemeli) {
            Swal.fire({
                title: 'صبر کنید ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('/user/azmoonPoshtibanMark') }}',
                type: 'POST',
                data: {exam_id:exam_id, codemeli:codemeli},
                success: function (response) {
                    Swal.close();
                    $('#modal_content').empty().html(response);
                    $('#modal_mark').modal('show');
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.warning(xhr.responseJSON.errors);
                }
            });
        }
    </script>
@stop

@section('content')

    <!-- Colored table options -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">آمار حضور دانش آموزان تا ساعت  {{\Morilog\Jalali\jDate::forge()->format('h:i')}}</h5>
        </div>


        <div class="table-responsive">
            @include('user.inspector.data')
        </div>
    </div>
    <!-- /colored table options -->
    <!-- Button options -->
{{--    <div class="row">--}}

{{--        <div class="panel panel-body border-top-primary text-center">--}}
{{--            <div class="btn-group btn-group-justified">--}}
{{--                <div class="btn-group col-md-12">--}}
{{--                    <button type="button" data-toggle="modal" data-target="#modal_default"--}}
{{--                            class="btn bg-pink-400 btn-raised">--}}
{{--                        بروزرسانی--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- /button options -->

    <!-- Basic modal -->
    <div id="modal_mark" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">نمره پشتیبان</h5>
                </div>

                <div class="modal-body" id="modal_content">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic modal -->
@stop
