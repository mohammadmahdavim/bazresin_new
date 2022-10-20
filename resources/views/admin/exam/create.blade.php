@extends('layouts.AdminLayouts')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/wizards/steps.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/core/libraries/jasny_bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/extensions/cookie.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/wizard_steps.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>



    <script>
        save_exam = function () {

            Swal.fire({
                title: 'صبر کنید ...',
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });
            $.ajaxSetup(
                {
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            var form = $('form')[0]; // You need to use standard javascript object here
            var data = new FormData(form);


            $.ajax({
                url: '{{ url('/admin/exams') }}',
                type: 'POST',
                data: data,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                success: function (data) {
                    if(!data.errors){
                        swal.close();
                        $("#alert_show").hide();
                        Swal.fire({
                            type: 'success',
                            title: 'با موفقیت ثبت گردید',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location.replace("{{url('/admin/exams')}}");
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
@stop
@section('content')

    <div class="alert alert-danger" style="display:none" id="alert_show"></div>
    <div class="alert alert-success" style="display:none" id="alert_show_success"></div>

    <!-- Basic layout-->
    <form action="{{url('/admin/exams')}}" class="form-horizontal" method="post" enctype="multipart/form-data" id="exam_upload">
        @csrf
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title">ایجاد آزمون</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-lg-3 control-label">نام آزمون<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="چیزی تایپ نمایید">
                        @if ($errors->has('name_azmoon'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">تاریخ آزمون<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" id="date1" class="form-control" name="date" value="{{old('date')}}" >
                        @if ($errors->has('date_azmoon'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('date') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">شماره تماس مسئول آزمون</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" value="{{old('supervisor')}}" name="supervisor" placeholder="...09">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">فایل پشتیبان ها<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="file" class="file-styled" name="import_file">
                        <span class="help-block">دریافت تمپلیت نمونه: <a href="{{url('/assets/templates/poshtibanT.xlsx')}}"> دانلود </a></span>
                        @if ($errors->has('import_file'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('import_file') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">فایل آرایش حوزه ها<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="file" class="file-styled" name="import_arrange">
                        <span class="help-block">دریافت تمپلیت نمونه: <a href="{{url('/assets/templates/arrangment.xlsx')}}"> دانلود </a></span>
                        @if ($errors->has('import_arrange'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('import_arrange') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">توضیحات آزمون:</label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" class="form-control" name="description">{{old('description')}}</textarea>
                        @if ($errors->has('description'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>

                <div class="text-right">
                    <a  class="btn btn-primary" onclick="save_exam()">آپلود آزمون<i class="icon-arrow-left13 position-right"></i></a>
                </div>
            </div>
        </div>
    </form>
    <!-- /basic layout -->
@stop



