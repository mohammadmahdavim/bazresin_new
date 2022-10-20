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


    <!-- TinyMCE init -->
    <script src="/assets/js/plugins/editors/tinymce/tinymce.min.js"></script>
    <script>
        var editor_config = {
            path_absolute : "",
            selector: "textarea[name=description]",
            plugins: [
                "link image directionality autolink hr autosave preview wordcount imagetools autoresize lists searchreplace save"
            ],
            directionality :"rtl",
            toolbar: "ltr rtl | undo redo | fontselect fontsizeselect styleselect | bullist numlist | link",
            language: "fa_IR",
            relative_urls: false,
            height: 129,
            content_css: ['//fonts.googleapis.com/css?family=Indie+Flower'],
            font_formats: 'Arial Black=arial black,IRANSans-web,avant garde;Indie Flower=indie flower, cursive;Times New Roman=times new roman,times;',

            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>

@stop
@section('content')
    <!-- Basic layout-->
    <form action="{{url('/admin/exams')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="name_azmoon" value="{{old('name_azmoon')}}" placeholder="چیزی تایپ نمایید">
                        @if ($errors->has('name_azmoon'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('name_azmoon') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">تاریخ آزمون<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" id="date1" class="form-control" name="date_azmoon" value="{{old('date_azmoon')}}" >
                        @if ($errors->has('date_azmoon'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('date_azmoon') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">شماره تماس مسئول آزمون</label>
                    <div class="col-lg-9">
                        <input type="text" class="form-control" value="{{old('mobile_supervisor')}}" name="mobile_supervisor" placeholder="...09">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">فایل ارزیابی حوزه<span style="color: red">*</span></label>
                    <div class="col-lg-9">
                        <input type="file" class="file-styled" name="import_file">
                        <span class="help-block">فرمت قابل قبول: xlsx</span>
                        @if ($errors->has('import_file'))
                            <div style="color:red;" class="form-control-feedback">
                                <i class="icon-cancel-circle2"></i>
                            </div>
                            <span  style="color:red;" class="help-block">{{ $errors->first('import_file') }}</span>
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
                    <button type="submit" class="btn btn-primary">آپلود آزمون<i class="icon-arrow-left13 position-right"></i></button>
                </div>
            </div>
        </div>
    </form>
    <!-- /basic layout -->
@stop
