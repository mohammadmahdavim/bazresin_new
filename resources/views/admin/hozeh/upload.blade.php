@extends('layouts.AdminLayouts')

@section('script')
    <script type="text/javascript" src="{{url('assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/uploader_bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/form_layouts.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/ui/ripple.min.js')}}"></script>
@stop

@section('css')

@stop

@section('content')


        <form action="{{route('fileUploadHozeh')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">بروزرسانی فایل حوزه ها</h5>
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning no-border">
                            <span class="text-semibold">{{$error}}</span>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span
                                    class="sr-only">Close</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-lg-3 control-label">فایل اکسل بروزرسانی</label>
                        <div class="col-lg-9">
                            <input type="file" class="file-styled" name="excel">
                            <span class="help-block">دقت داشته باشید که حتما بر اساس تمپلیت تعریف شده سایت اقدام به بروزرسانی نمایید</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">بروزرسانی<i
                                class="icon-arrow-left13 position-right"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <!-- /basic layout -->

    {{--    <script type="text/javascript">--}}
    {{--        $("#file-1").fileinput({--}}
    {{--            theme: 'fa',--}}
    {{--            uploadUrl: "{{url('/admin/hozeh/upload')}}",--}}
    {{--            uploadExtraData: function() {--}}
    {{--                return {--}}
    {{--                    _token: $("input[name='_token']").val(),--}}
    {{--                };--}}
    {{--            },--}}
    {{--            allowedFileExtensions: ['jpg', 'png', 'gif','xlsx'],--}}
    {{--            overwriteInitial: false,--}}
    {{--            maxFileSize:2000,--}}
    {{--            maxFilesNum: 10,--}}
    {{--            slugCallback: function (filename) {--}}
    {{--                return filename.replace('(', '_').replace(']', '_');--}}
    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}

@stop
