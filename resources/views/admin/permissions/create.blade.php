@extends('layouts.AdminLayouts')

@section('script')

@stop

@section('css')

@stop

@section('content')


    <div class="row">
        {!! Form::open(['url'=>'admin/permissions']) !!}
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">ایجاد مجوز جدید</h5>
                    <div class="heading-elements">
                        <a href="{{ url('admin/permissions') }}" class="btn bg-blue btn-xs btn-icon">بازگشت به مدیریت مجوز ها<i class="icon-backward"></i></a>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="form-group">
                        <label>نام لاتین مجوز</label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: manege-user">
                    </div>

                    <div class="form-group">
                        <label>عنوان مجوز</label>
                        <input type="text" name="label" class="form-control" placeholder="مثال: مدیریت کاربران">
                    </div>

                    <div class="text-right">
                        {!! Form::submit('ثبت مجوز',['class'=>'btn btn-success']) !!}
                    </div>
                </div>

            </div>


        </div>
        {!! Form::close() !!}
    </div>
@endsection

