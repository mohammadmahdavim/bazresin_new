@extends('layouts.AdminLayouts')

@section('script')
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/pages/form_layouts.js')}}"></script>
    <script type="text/javascript" src="{{url('/assets/js/plugins/ui/ripple.min.js')}}"></script>

@stop

@section('css')

@stop

@section('content')

    <div class="row">
        {!! Form::open(['url'=>'admin/roles']) !!}
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">ایجاد نقش جدید</h5>
                    <div class="heading-elements">
                        <a href="{{ url('admin/roles') }}" class="btn bg-blue btn-xs btn-icon">بازگشت به مدیریت نقش ها<i class="icon-backward"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label>نام لاتین نقش</label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: admin">
                    </div>

                    <div class="form-group">
                        <label>عنوان نقش</label>
                        <input type="text" name="label" class="form-control" placeholder="مثال: مدیر">
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            {!! Form::label('permission_id','دسترسی ها: ') !!}
                            <div class="multi-select-full">
                            {!! Form::select('permission_id[]',$permissions , null,['class'=>'select-icons','multiple'=>'multiple'] ) !!}
                            @if($errors->has('permission_id'))
                                <span style="color:red;font-size:13px">{{ $errors->first('permission_id') }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {!! Form::submit('ثبت نقش',['class'=>'btn btn-success']) !!}
                    </div>
                </div>

            </div>


        </div>
        {!! Form::close() !!}
    </div>


@endsection
