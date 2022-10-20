@extends('layouts.UserLayouts')

@section('script')
    <script>
        $(document).on("click", ".start", function () {
            var id = $(this).data('id');
            var el = this;

            Swal.fire({
                title: 'از انجام عملیات مطمئن هستید؟',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00a018',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ url('user/bazresLogSave') }}',
                        type: 'POST',
                        data: {
                            "exam_id": id,
                            "_token": '{{csrf_token()}}',
                        },

                        success: function (data) {
                            if (data.status === 200) {
                                Swal.fire(
                                    'موفق',
                                    data.messages,
                                    'success'
                                );
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                Swal.fire(
                                    'خطا',
                                    data.errors,
                                    'error'
                                )
                            }
                        }
                    });
                }
            });
        });

    </script>
@endsection

@section('content')
    <div class="row">
        @if(empty($log))
            <div class="col-sm-12 col-md-12 ">
                <a class='start' data-id='<?= $exam_id ?>'>
                    <div class="panel panel-body bg-success-400 has-bg-image">
                        <div class="media no-margin">
                            <div class="media-left media-middle">
                                <i class="icon-play3 icon-3x opacity-75"></i>
                            </div>

                            <div class="media-body text-right">
                                <h3 class="no-margin">{{\Morilog\Jalali\jDate::forge()->format('time')}}</h3>
                                <span class="text-uppercase text-size-mini">برای شروع بازرسی کلیک نمایید</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @elseif($log->finish_exam == '')
            <div class="col-sm-12 col-md-12 ">
                <a class='start' data-id='<?= $exam_id ?>'>
                    <div class="panel panel-body bg-orange-400 has-bg-image">
                        <div class="media no-margin">
                            <div class="media-left media-middle">
                                <i class="icon-stop icon-3x opacity-75"></i>
                            </div>

                            <div class="media-body text-right">
                                <h3 class="no-margin">{{\Morilog\Jalali\jDate::forge()->format('time')}}</h3>
                                <span class="text-uppercase text-size-mini">برای پایان بازرسی کلیک نمایید</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif

    </div>
    <div class="row">
        <div class="col-sm-12">

            @if(empty($log))
                <div class="panel panel-body border-top-warning">
                    <ul class="list-feed">
                        <li>
                            هیچ لاگی ذخیره نشده است! برای شروع بازرسی بر روی دکمه بالا کلیک نمایید.
                        </li>
                    </ul>
                </div>
            @else
            <!-- Circle empty -->
                <div class="panel panel-body border-top-warning">
                    <ul class="list-feed">
                        <li>
                            شما در ساعت {{\Morilog\Jalali\jDate::forge((int)$log->start_exam)->format('time')}} بازرسی خود را شروع نموده اید.
                        </li>

{{--                        <li>--}}
{{--                            حوزه مورد ارزیابی شما، فلان می باشد.--}}
{{--                        </li>--}}

                        @if($log->finish_exam != '')
                            <li>
                                شما در ساعت {{\Morilog\Jalali\jDate::forge((int)$log->finish_exam)->format('time')}} بازرسی خود را به اتمام رسانده اید.
                            </li>
                        @endif

                    </ul>
                </div>
                <!-- /circle empty -->
            @endif
        </div>
    </div>
@stop
